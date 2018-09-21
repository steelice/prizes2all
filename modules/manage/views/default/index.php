<?php
/**
 * @var $this
 * @var array $totals
 * @var array $itemStat
 */

$this->title = Yii::t('app', 'Администрация');

?>
<div class="manage-default-index">

    <div class="row">
        <div class="col-sm-3">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Всего призов выдано</span>
                    <span class="info-box-number"><?= $totals['total'] ?></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>
        <div class="col-sm-3">
            <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-archive"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Предметов</span>
                    <span class="info-box-number"><?= $totals['item'] ?></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>
        <div class="col-sm-3">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-certificate"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Бонусов</span>
                    <span class="info-box-number"><?= $totals['bonus'] ?></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>
        <div class="col-sm-3">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Денег</span>
                    <span class="info-box-number"><?= $totals['money'] ?></span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-archive"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Остаток подарков</span>
                    <span class="info-box-number"><?= $itemStat['notTaken'] ?> (<?= $itemStat['percent'] ?>%)</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: <?= $itemStat['percent'] ?>%"></div>
                    </div>
                    <span class="progress-description">
                        <?= $itemStat['total'] ?>
                    </span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>
    </div>


</div>
