<?php

namespace app\commands;


use app\components\delivery\DeliveryFactory;
use app\models\PrizeType;
use app\models\PrizeUser;
use yii\console\Controller;
use yii\helpers\Console;

class MoneyController extends Controller
{
    public const DEFAULT_PRIZES_COUNT = 10;

    /**
     * Отправляет все неотправленные денежные призы
     *
     * @throws \Exception
     */
    public function actionSend($count = 0): void
    {
        if (!$count) {
            $count = \Yii::$app->params['cronPrizesCount'] ?? self::DEFAULT_PRIZES_COUNT;
        }

        $prizes = PrizeUser::find()
            ->where([
                'status' => PrizeUser::STATUS_ACCEPTED,
                'typeId' => PrizeType::find()->select('id')->where(['name' => PrizeType::MONEY_INDEX])
            ])
            ->with('user')
            ->limit($count)
            ->all();

        if ($prizes) {
            $this->stdout(\Yii::t('app', 'Sending {prizes} prize(s)...' . PHP_EOL,
                ['prizes' => count($prizes)]), Console::FG_GREEN);
        } else {
            $this->stdout(\Yii::t('app', 'Nothing to send!' . PHP_EOL), Console::FG_YELLOW);
        }

        foreach ($prizes as $prize) {
            $this->stdout(\Yii::t('app', 'Sending {money} money to {user}...', [
                'money' => $prize->value,
                'user' => $prize->user->email
            ]));
            $delivery = DeliveryFactory::getDelivery($prize);
            $delivery->delivery();
            $this->stdout(\Yii::t('app', ' [SENT]' . PHP_EOL), Console::FG_GREEN);
        }
    }
}