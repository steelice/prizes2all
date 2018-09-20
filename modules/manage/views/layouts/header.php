<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <?= '<li>'
                . Html::beginForm(['/user/security/logout'], 'post')
                . Html::submitButton(
                    Yii::t('app', 'Выйти ({email})', ['email' => Yii::$app->user->identity->email]),
                    ['class' => 'btn btn-link logout', 'style' => 'color: white;']
                )
                . Html::endForm()
                . '</li>' ?>

            </ul>
        </div>
    </nav>
</header>
