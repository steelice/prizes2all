<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property string $name Ключ
 * @property string $title Заголовок
 * @property string $value Значение
 * @property string $type Тип поля
 * @property string $updatedAt Последнее изменение
 */
class Setting extends \yii\db\ActiveRecord
{
    public const MONEY = 'money';
    public const MONEY_MIN = 'money_min';
    public const MONEY_MAX = 'money_max';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'title'], 'required'],
            [['value', 'type'], 'string'],
            [['updatedAt'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['title'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Ключ'),
            'title' => Yii::t('app', 'Заголовок'),
            'value' => Yii::t('app', 'Значение'),
            'type' => Yii::t('app', 'Тип поля'),
            'updatedAt' => Yii::t('app', 'Последнее изменение'),
        ];
    }
}
