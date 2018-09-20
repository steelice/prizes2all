<?php
/* @var $this yii\web\View */

use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

/* @var $config \app\models\Setting[] */

$this->title = Yii::t('app', 'Настройки');
$this->params['breadcrumbs'][] = $this->title;

?>

    <h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>

<?php foreach ($config as $cfgItem): ?>

    <div class="form-group row">
        <label class="col-md-3 control-label"><?= $cfgItem->title ?></label>
        <div class="col-md-9">
            <?php

            switch ($cfgItem->type) {
                case 'string':
                    ?><input type="text" class="form-control" name="data[<?= $cfgItem->name ?>]"
                             value="<?= @htmlspecialchars($cfgItem->value) ?>"><?php
                    break;
                case 'number':
                    ?><input style="width: 5em;" type="text" class="form-control" name="data[<?= $cfgItem->name ?>]"
                             value="<?= @htmlspecialchars($cfgItem->value) ?>"><?php
                    break;
                case 'text':
                    ?><textarea rows="5" type="text" class="form-control"
                                name="data[<?= $cfgItem->name ?>]" ><?= @htmlspecialchars($cfgItem->value) ?></textarea><?php
                    break;
            }

            ?>
        </div>
    </div>

<?php endforeach; ?>

<?= Html::submitButton(Yii::t('app', '<i class="fa fa-save"></i> Сохранить изменения'), ['class' => 'btn btn-primary']) ?>


<?php ActiveForm::end(); ?>