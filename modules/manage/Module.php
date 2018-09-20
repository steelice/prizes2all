<?php

namespace app\modules\manage;

use yii\web\ForbiddenHttpException;

/**
 * manage module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\manage\controllers';

    /**
     * {@inheritdoc}
     * @throws ForbiddenHttpException
     */
    public function init()
    {
        // для не-админов модуль просто не запустится
        if (\Yii::$app->user->isGuest || !\Yii::$app->user->identity->isAdmin) {
            throw new ForbiddenHttpException(\Yii::t('app', 'У вас нет доступа в эту часть'));
        }
        parent::init();
        $this->layout = 'main.php';
    }
}
