<?php

namespace app\components;


use app\models\PrizeItem;
use app\models\PrizeType;
use app\models\PrizeUser;
use app\models\Setting;
use app\models\Transaction;
use app\models\User;
use yii\base\Component;
use yii\base\Exception;

class PrizeStorage extends Component
{

    protected $settings;

    public function __construct(Settings $settings, array $config = [])
    {
        $this->settings = $settings;
        parent::__construct($config);
    }

    /**
     * Возвращает случайный приз с учётом шанса его выпадения
     *
     * @return PrizeType|null
     */
    public function getRandom(): ?PrizeType
    {
        $prizesPool = [];
        $chancesSum = 0;
        $prizesAll = PrizeType::find()->indexBy('name')->all();
        $moneyMin = $this->settings->get(Setting::MONEY_MIN);
        $moneyMax = max($this->settings->get(Setting::MONEY_MAX), $this->settings->get(Setting::MONEY));

        // денежные призы добавляем в пул только при наличии денег
        if (($moneyMax >= $moneyMin) && isset($prizesAll[PrizeType::MONEY_INDEX])) {
            $chancesSum += $prizesAll[PrizeType::MONEY_INDEX]->chance;
            $prizesPool[PrizeType::MONEY_INDEX] = $chancesSum;
        }

        // бонусный приз добавляется всегда, но при наличии его в конфиге (но по идее всегда)
        if (isset($prizesAll[PrizeType::BONUS_INDEX])) {
            $chancesSum += $prizesAll[PrizeType::BONUS_INDEX]->chance;
            $prizesPool[PrizeType::BONUS_INDEX] = $chancesSum;
        }

        // приз-вещь добавляем только при наличии свободных
        if (isset($prizesAll[PrizeType::ITEM_INDEX]) && PrizeItem::findOne(['taken' => 0])) {
            $chancesSum += $prizesAll[PrizeType::ITEM_INDEX]->chance;
            $prizesPool[PrizeType::ITEM_INDEX] = $chancesSum;
        }

        // вдруг в системе не установлено призов вообще
        if (!$chancesSum) {
            return null;
        }

        try {
            $n = random_int(1, $chancesSum);
            foreach ($prizesPool as $prizeKey => $chance) {
                if ($n <= $chance) {
                    return $prizesAll[$prizeKey];
                }
            }
        } catch (\Exception $e) {

        }

        return null;
    }

    /**
     * Назначает переданному пользователю приз
     *
     * @param User $user
     * @return PrizeUser
     * @throws Exception
     */
    public function takeRandom(User $user): PrizeUser
    {

        /**
         * По ТЗ нет ограничений по получению призов для пользователя.
         * Но по-хорошему бы тут сделать проверку на частоту получения призов, итд
         */

        if (!$prizeType = $this->getRandom()) {
            throw new Exception(\Yii::t('app', 'Невозможно получить ни единого приза!'));
        }

        $transaction = \Yii::$app->getDb()->beginTransaction();

        $prize = new PrizeUser();
        $prize->typeId = $prizeType->id;
        $prize->userId = $user->id;

        if (PrizeType::ITEM_INDEX === $prizeType->name) {
            if (!$item = PrizeItem::getRandom()) {
                throw new Exception(\Yii::t('app', 'Невозможно получить приз вашего типа! Попробуйте ещё раз!'));
            }
            $prize->itemId = $item->id;
            $item->taken = 1;
            $item->save();
        } else {
            $prize->value = $prizeType->getRandomValue();


        }


        if (!$prize->save()) {
            throw new Exception(\Yii::t('app', 'Невозможно сохранить ваш приз!'));
        }

        // если приз денежный, то уменьшаем кол-во оставшихся денег и создаём транзакцию
        if (PrizeType::MONEY_INDEX === $prizeType->name) {
            Setting::updateAllCounters(['value' => -$prize->value], ['name' => Setting::MONEY]);
            Transaction::log($prize);
        }

        $transaction->commit();

        // перегружаем приз из базы, чтобы обновились таймштампы и релейшены
        $prize->refresh();

        return $prize;
    }
}