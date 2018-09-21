<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::t('app', 'Prizes2All'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $widgetItems = [
        ['label' => Yii::t('app', 'Главная'), 'url' => Yii::$app->homeUrl],
        ['label' => Yii::t('app', 'О компании'), 'url' => ['/site/about']],
        ['label' => Yii::t('app', 'Контакты'), 'url' => ['/site/contact']],
    ];

    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin) {
        $widgetItems[] = [
            'label' => Yii::t('app', 'Администрация'),
            'url' => ['/manage']
        ];
    }

    if (Yii::$app->user->isGuest) {
        $widgetItems[] = ['label' => 'Войти', 'url' => ['/user/security/login']];
    } else {
        $widgetItems[] = ['label' => Yii::t('app', 'Бонусы: {bonuses}', ['bonuses' => Yii::$app->user->identity->bonuses]), 'url' => '#'];
        $widgetItems[] = '<li>'
            . Html::beginForm(['/user/security/logout'], 'post')
            . Html::submitButton(
                Yii::t('app', 'Выйти ({email})', ['email' => Yii::$app->user->identity->email]),
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $widgetItems
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Prizes2All <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
