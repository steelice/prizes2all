<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property string $createdAt Дата проведения
 * @property int $userId Пользователь
 * @property double $money Сумма
 * @property int $prizeId
 *
 * @property PrizeUser $prize
 * @property User $user
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * Записывает транзакцию о перемещении средств
     * @param PrizeUser $prize
     * @return Transaction
     */
    public static function log(PrizeUser $prize): self
    {
        $t = new self();
        $t->userId = $prize->user->id;
        $t->money = $prize->value;
        $t->prizeId = $prize->id;

        $t->save();

        return $t;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createdAt'], 'safe'],
            [['userId'], 'required'],
            [['userId', 'prizeId'], 'integer'],
            [['money'], 'number'],
            [['prizeId'], 'exist', 'skipOnError' => true, 'targetClass' => PrizeUser::className(), 'targetAttribute' => ['prizeId' => 'id']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'createdAt' => Yii::t('app', 'Дата проведения'),
            'userId' => Yii::t('app', 'Пользователь'),
            'money' => Yii::t('app', 'Сумма'),
            'prizeId' => Yii::t('app', 'Prize ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrize()
    {
        return $this->hasOne(PrizeUser::className(), ['id' => 'prizeId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
}
