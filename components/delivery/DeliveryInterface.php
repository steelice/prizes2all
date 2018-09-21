<?php

namespace app\components\delivery;


interface DeliveryInterface
{
    public function delivery(): void;

    public function cancel(): void;
}