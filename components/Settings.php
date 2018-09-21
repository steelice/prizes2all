<?php

namespace app\components;


use app\models\Setting;
use yii\base\Component;

/**
 * Class Settings
 * Компонент для работы с настройками.
 * В будущем можно добавить кеширование, итд
 *
 * @package app\components
 */
class Settings extends Component
{
    protected $data = [];

    public function init()
    {
        parent::init();
        $this->data = Setting::find()->select('value')->indexBy('name')->column();
    }

    /**
     * @param string $name Ключ настройки
     * @param null $default Значение по умолчанию
     * @return mixed|null Значение настройки
     */
    public function get($name, $default = null)
    {
        return $this->data[$name] ?? $default;
    }
}