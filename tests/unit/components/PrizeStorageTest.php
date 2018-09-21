<?php

namespace tests\components;


use app\components\PrizeStorage;
use app\models\PrizeType;
use Codeception\Test\Unit;

class PrizeStorageTest extends Unit
{
    /**
     * Проверяем, что призы распределяются равномерно.
     * Чисто в теории он может когда-то падать, но если генератор случайных чисел работает нормально, то не будет
     *
     * WARNING
     * По-правильному, тут должна использоваться отдельная база данных и перед проверкой в базе должно быть установлен
     * шанс выпадения всех призов на одном уровне (с помощью фикстур, например).
     * Но,  для экономии времени на тестовом задании используется прод-база и, соответственно,
     * для успешного прохождения этого теста, у всех призов должно быть одинаковое значение chance в админке.
     * Также должен быть хотя бы один свободный товар
     *
     * @throws \yii\base\InvalidConfigException
     * @throws \Exception
     */
    public function testGetRandom()
    {
        $prizeStorage = \Yii::createObject(PrizeStorage::class);

        $count = [
            PrizeType::BONUS_INDEX => 0,
            PrizeType::ITEM_INDEX => 0,
            PrizeType::MONEY_INDEX => 0,
        ];

        for ($i = 1; $i <= 3000; $i++) {
            $prize = $prizeStorage->getRandom();
            expect_that($prize);

            $count[$prize->name]++;
        }

        // всех призов должно быть примерно по 1000
        foreach ($count as $itemCount) {
            $this->assertEquals(10, (int)round($itemCount / 100));
        }
    }
}