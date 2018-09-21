<?php

namespace app\components;


use app\models\PrizeUser;
use app\models\Setting;
use app\models\Transaction;
use yii\base\Component;


/**
 * Компонент для работы с деньгами
 *
 * Class MoneyStorage
 * @package app\components
 */
class MoneyStorage extends Component
{
    protected $settings;

    public function __construct(Settings $settings, array $config = [])
    {
        $this->settings = $settings;
        parent::__construct($config);
    }

    /**
     * Минимальная сумма денег к начислению
     *
     * @return int
     */
    public function getMin(): int
    {
        return $this->settings->get(Setting::MONEY_MIN);
    }

    /**
     * Максимальная сумма денег к начислению с учётом остатка
     *
     * @return int
     */
    public function getMax(): int
    {
        return min($this->settings->get(Setting::MONEY_MAX), $this->settings->get(Setting::MONEY));
    }

    /**
     * Хватает ли денег на счету, чтобы выдать приз
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->getMin() <= $this->getMax();
    }

    /**
     * Возвращает случайное количество денег в установленом ренже и с учетом остатка
     *
     * @return int
     * @throws \Exception
     */
    public function randomValue(): int
    {
        return $this->isAvailable() ? random_int($this->getMin(), $this->getMax()) : 0;
    }

    /**
     * @param $money
     * @return float|int
     */
    public function convertToBonus($money)
    {
        return $this->settings->get(Setting::BONUS_RATE) * $money;
    }

    /**
     * Блокирует средства на счету
     *
     * @param $money
     */
    public function block($money): void
    {
        Setting::updateAllCounters(['value' => -$money], ['name' => Setting::MONEY]);
    }

    /**
     * Разблокирывает деньги на счету
     *
     * @param $money
     */
    public function unblock($money): void
    {
        Setting::updateAllCounters(['value' => $money], ['name' => Setting::MONEY]);
    }

    /**
     * Выплачивает деньги по призу
     *
     * @param PrizeUser $prize
     */
    public function pay(PrizeUser $prize): void
    {
        \Yii::$app->bankAPI->sendMoney($prize->value, $prize->userNotes);
        Transaction::log($prize);
    }
}