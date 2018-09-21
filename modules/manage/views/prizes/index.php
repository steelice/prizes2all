<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PrizeUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Призы');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prize-user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'createdAt',
                'filter' => false,
            ],
            [
                'attribute' => 'user.email',
                'header' => 'Пользователь',
            ],

            [
                'attribute' => 'typeId',
                'content' => function (\app\models\PrizeUser $model) {
                    $str = $model->type->title . ': ';
                    switch ($model->type->name) {
                        case \app\models\PrizeType::MONEY_INDEX:
                            $str .= Yii::t('app', '<span class="label label-success">{money} денег</span>', ['money' => $model->value]);
                            break;
                        case \app\models\PrizeType::BONUS_INDEX:
                            $str .= Yii::t('app', '<span class="label label-info">{money} бонусов</span>', ['money' => $model->value]);
                            break;
                        case \app\models\PrizeType::ITEM_INDEX:
                            $str .= '<span class="label label-default">' . $model->item->name . '</span>';
                            break;
                    }

                    return $str;
                },
                'filter' => \app\models\PrizeType::find()->indexBy('id')->select('title')->column()
            ],
            [
                'attribute' => 'status',
                'filter' => \app\models\search\PrizeUser::statuses(),
                'content' => function (\app\models\PrizeUser $model) {
                    return $model->getStatusName();
                }
            ],

            'userNotes:ntext',

            [
                'content' => function (\app\models\PrizeUser $model) {
                    $str = '<div class="btn-group btn-group-xs" role="group">';
                    switch ($model->status) {
                        case \app\models\PrizeUser::STATUS_NEW:
                            $str .= \yii\bootstrap\Html::a(Yii::t('app', 'Отправить'), ['send', 'id' => $model->id], [
                                    'data' => [
                                        'method' => 'post'
                                    ],
                                    'class' => 'btn btn-success'
                                ]) .
                                \yii\bootstrap\Html::a(Yii::t('app', 'Отменить'), ['cancel', 'id' => $model->id], [
                                    'data' => [
                                        'method' => 'post'
                                    ],
                                    'class' => 'btn btn-danger'
                                ]);
                            break;
                    }

                    if ($model->type->name === \app\models\PrizeType::MONEY_INDEX && $model->status === \app\models\PrizeUser::STATUS_NEW) {
                        $str .= \yii\bootstrap\Html::a(Yii::t('app', 'В бонусы'), ['convert-to-bonus', 'id' => $model->id], [
                            'data' => [
                                'method' => 'post'
                            ],
                            'class' => 'btn btn-primary'
                        ]);
                    }

                    $str .= '</div>';

                    return $str;
                }
            ]

        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
