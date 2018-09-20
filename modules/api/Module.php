<?php

namespace app\modules\api;

use Yii;
use yii\web\Response;

/**
 * api module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        Yii::$app->response->format = Response::FORMAT_JSON;
        $this->modules = [
            'v1' => \app\modules\api\modules\v1\Module::class,
        ];
    }

}
