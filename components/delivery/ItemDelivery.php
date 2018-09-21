<?php

namespace app\components\delivery;


use app\models\PrizeUser;

class ItemDelivery extends BaseDelivery implements DeliveryInterface
{

    /**
     * Просто помечаем, что товар отправлен
     */
    public function delivery(): void
    {
        $this->prize->status = PrizeUser::STATUS_SENT;
        $this->prize->save();
    }

    /**
     * Кроме обычной пометки, также освобождаем товар для взятия в другой приз
     */
    public function cancel(): void
    {
        $this->prize->status = PrizeUser::STATUS_CANCELLED;
        $this->prize->save();

        $this->prize->item->taken = 0;
        $this->prize->item->save();
    }
}