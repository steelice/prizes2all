<?php

namespace app\components;


use yii\base\Component;

/**
 * Компонент для работы с банком
 *
 * Class BankAPI
 * @package app\components
 */
class BankAPI extends Component
{
    public $apiKey;

    /**
     * Метод-фейк отправки денег через АПИ-метод банка. В реальности должен вызываться HTTP-запрос
     *
     * @param int|float $money Сумма
     * @param string $destination Данные платежа (счёт, например)
     * @throws \Exception
     */
    public function sendMoney($money, $destination): void
    {
        if (!$destination) {
            throw new \Exception(\Yii::t('app', 'Данные платежа не указаны!'));
        }

        if (!$money || ($money < 0)) {
            throw new \Exception(\Yii::t('app', 'Сумма для отправки некорректна!'));
        }

        \Yii::info(\Yii::t('app', 'Payed {money} to {destination} with api key: {key}', [
            'money' => $money,
            'destination' => $destination,
            'key' => $this->apiKey
        ]));
    }
}