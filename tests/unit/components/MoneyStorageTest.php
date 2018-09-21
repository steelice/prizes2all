<?php

namespace tests\components;


use app\components\MoneyStorage;
use Codeception\Test\Unit;

class MoneyStorageTest extends Unit
{

    /**
     * Тут правильнее сделать фикстуру с настройкой, и на отдельной базе тестировать
     * Но для просты я возьму текущее значение курса 10
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function dpRates(): array
    {
        return [
            [10, 100], // целые
            [0.1, 1], // дробные
            [-10, -100], // отрицательные
        ];
    }

    /**
     *
     * @dataProvider dpRates
     * @throws \yii\base\InvalidConfigException
     * @throws \Exception
     */
    public function testConvertToBonus($money, $bonuses)
    {
        $moneyStorage = \Yii::createObject(MoneyStorage::class);
        $this->assertEquals($bonuses, $moneyStorage->convertToBonus($money));
    }
}