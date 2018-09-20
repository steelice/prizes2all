<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PrizeItem */

$this->title = Yii::t('app', 'Добавление предмета');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Предметы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prize-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
