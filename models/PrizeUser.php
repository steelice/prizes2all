<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prizeUser".
 *
 * @property int $id
 * @property int $userId
 * @property string $createdAt
 * @property int $typeId
 * @property int $itemId Предмет (если есть)
 * @property int $value Сумма (для бонусов или денег)
 * @property string $status Статус
 * @property string $userNotes Примечание пользователя
 *
 * @property PrizeItem $item
 * @property PrizeType $type
 * @property User $user
 * @property Transaction[] $transactions
 */
class PrizeUser extends \yii\db\ActiveRecord
{
    public const STATUS_NEW = 'new';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_SENT = 'sent';
    public const STATUS_ERROR = 'error';
    public const STATUS_CANCELLED = 'cancelled';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prizeUser';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'typeId'], 'required'],
            [['userId', 'typeId', 'itemId', 'value'], 'integer'],
            [['createdAt'], 'safe'],
            [['status', 'userNotes'], 'string'],
            [['itemId'], 'exist', 'skipOnError' => true, 'targetClass' => PrizeItem::className(), 'targetAttribute' => ['itemId' => 'id']],
            [['typeId'], 'exist', 'skipOnError' => true, 'targetClass' => PrizeType::className(), 'targetAttribute' => ['typeId' => 'id']],
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
            'userId' => Yii::t('app', 'User ID'),
            'createdAt' => Yii::t('app', 'Дата получения'),
            'typeId' => Yii::t('app', 'Тип'),
            'itemId' => Yii::t('app', 'Предмет (если есть)'),
            'value' => Yii::t('app', 'Сумма (для бонусов или денег)'),
            'status' => Yii::t('app', 'Статус'),
            'userNotes' => Yii::t('app', 'Примечание пользователя'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(PrizeItem::className(), ['id' => 'itemId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(PrizeType::className(), ['id' => 'typeId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::className(), ['prizeId' => 'id']);
    }

    public function fields()
    {
        return ['value', 'status', 'typeId'];
    }

    public function extraFields()
    {
        return ['type'];
    }

    /**
     * Список возможных статусов приза
     *
     * @return array
     */
    public static function statuses(): array
    {
        return [
            self::STATUS_NEW => Yii::t('app', 'Новый'),
            self::STATUS_ACCEPTED => Yii::t('app', 'Выполняется'),
            self::STATUS_SENT => Yii::t('app', 'Отправлен'),
            self::STATUS_CANCELLED => Yii::t('app', 'Отменен'),
            self::STATUS_ERROR => Yii::t('app', 'Ошибка'),
        ];
    }

    /**
     * Возвращает человекочитаемый статус приза
     *
     * @return string
     */
    public function getStatusName(): string
    {
        return self::statuses()[$this->status] ?? $this->status;
    }
}
