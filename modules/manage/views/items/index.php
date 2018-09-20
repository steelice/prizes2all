<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PrizeItem */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Предметы');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prize-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', '<i class="fa fa-plus-circle"></i> Добавить'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'name',
            [
                'attribute' => 'taken',
                'filter' => [
                    '0' => Yii::t('app', 'Доступен'),
                    '1' => Yii::t('app', 'Взят'),
                ],
                'content' => function (\app\models\PrizeItem $model) {
                    return $model->taken ? '<i class="fa fa-check-circle text-danger"></i> Взят' : '<i class="fa fa-circle text-success"></i> Доступен';
                }
            ],
            ['attribute' => 'createdAt', 'filter' => false],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
