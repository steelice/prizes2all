<?php

namespace app\components\delivery;


use app\models\PrizeType;
use app\models\PrizeUser;
use app\models\Setting;
use yii\db\Exception;

class MoneyDelivery extends BaseDelivery implements DeliveryInterface
{

    /**
     * О том, что деньги ушли, создаем транзакцию.
     * При создании приза сумма доступных денег уже снялась, поэтому повторно запас не уменьшаем
     *
     */
    public function delivery(): void
    {
        \Yii::$app->money->pay($this->prize);

        $this->prize->status = PrizeUser::STATUS_SENT;
        $this->prize->save();
    }

    /**
     * Кроме статуса, возвращаем деньги назад «разблокируем»
     */
    public function cancel(): void
    {
        Setting::updateAllCounters(['value' => $this->prize->value], ['name' => Setting::MONEY]);

        $this->prize->status = PrizeUser::STATUS_CANCELLED;
        $this->prize->save();
    }

    /**
     * Конвертирует денежный приз в бонусный
     *
     * @throws Exception
     * @throws \Exception
     */
    public function convertToBonus()
    {
        if (!$bonusType = PrizeType::findOne(['name' => PrizeType::BONUS_INDEX])) {
            throw new Exception('Bonus prize type not found!');
        }
        $this->prize->typeId = $bonusType->id;
        $this->prize->value = \Yii::$app->money->convertToBonus($this->prize->value);
        $this->prize->save();
        $this->prize->refresh(); // для обновления связи

        $delivery = DeliveryFactory::getDelivery($this->prize);
        $delivery->delivery();
    }
}