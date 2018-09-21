<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prizeType".
 *
 * @property int $id
 * @property string $name Внутреннее имя
 * @property string $title Тип
 * @property string $description Описание приза
 * @property int $chance Шанс выпадения
 *
 * @property PrizeUser[] $prizeUsers
 */
class PrizeType extends \yii\db\ActiveRecord
{
    public const MONEY_INDEX = 'money';
    public const BONUS_INDEX = 'bonus';
    public const ITEM_INDEX = 'item';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prizeType';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'title', 'description'], 'required'],
            [['description'], 'string'],
            [['chance'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 100],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Внутреннее имя'),
            'title' => Yii::t('app', 'Тип'),
            'description' => Yii::t('app', 'Описание приза'),
            'chance' => Yii::t('app', 'Шанс выпадения'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrizeUsers()
    {
        return $this->hasMany(PrizeUser::className(), ['typeId' => 'id']);
    }

    /**
     * Возвращает случайное значение в зависимости от типа приза
     *
     * @return int
     */
    public function getRandomValue(): int
    {
        try {
            if (self::MONEY_INDEX === $this->name) {
                return random_int(Yii::$app->settings->get('money_min'),
                    max(Yii::$app->settings->get('money_max'), Yii::$app->settings->get('money')));
            }

            if (self::BONUS_INDEX === $this->name) {
                return random_int(Yii::$app->settings->get('bonus_min'), Yii::$app->setting->get('bonus_max'));
            }

        } catch (\Exception $e) {

        }

        return 0;
    }
}
