<?php

namespace app\components\delivery;


use app\models\PrizeType;
use app\models\PrizeUser;

class DeliveryFactory
{
    /**
     * Фабрика для доставки приза
     *
     * @param PrizeUser $prize
     * @return BonusDelivery|ItemDelivery|MoneyDelivery
     * @throws \Exception
     */
    public static function getDelivery(PrizeUser $prize): DeliveryInterface
    {
        switch ($prize->type->name) {
            case PrizeType::MONEY_INDEX:
                return new MoneyDelivery($prize);
            case PrizeType::BONUS_INDEX:
                return new BonusDelivery($prize);
            case PrizeType::ITEM_INDEX:
                return new ItemDelivery($prize);
            default:
                throw new \Exception('Unknown delivery');
        }
    }
}