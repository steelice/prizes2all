<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PrizeType */

$this->title = Yii::t('app', 'Редактирование типа приза: ' . $model->name, [
    'nameAttribute' => '' . $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Типы призов'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="prize-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
