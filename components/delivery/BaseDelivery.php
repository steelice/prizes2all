<?php

namespace app\components\delivery;


use app\models\PrizeUser;

abstract class BaseDelivery
{
    /** @var PrizeUser */
    public $prize;

    public function __construct(PrizeUser $prize)
    {
        $this->prize = $prize;
    }
}