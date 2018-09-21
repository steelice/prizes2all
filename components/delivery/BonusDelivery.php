<?php

namespace app\components\delivery;


use app\models\PrizeUser;

class BonusDelivery extends BaseDelivery implements DeliveryInterface
{

    public function delivery(): void
    {
        $this->prize->user->updateCounters(['bonuses' => $this->prize->value]);
        $this->prize->status = PrizeUser::STATUS_SENT;
        $this->prize->save();
    }

    public function cancel(): void
    {
        $this->prize->status = PrizeUser::STATUS_CANCELLED;
        $this->prize->save();
    }
}