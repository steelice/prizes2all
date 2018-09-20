<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prizeItem".
 *
 * @property int $id ID
 * @property string $createdAt Дата добавления
 * @property string $updatedAt Дата изменения
 * @property string $name Название
 * @property int $taken Предмет взят
 */
class PrizeItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prizeItem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createdAt', 'updatedAt'], 'safe'],
            [['name'], 'required'],
            [['taken'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'createdAt' => Yii::t('app', 'Дата добавления'),
            'updatedAt' => Yii::t('app', 'Дата изменения'),
            'name' => Yii::t('app', 'Название'),
            'taken' => Yii::t('app', 'Доступность'),
        ];
    }
}
