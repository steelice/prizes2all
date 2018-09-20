<?php

namespace app\modules\manage\controllers;


use app\models\Setting;
use yii\web\Controller;

class SettingsController extends Controller
{
    public function actionIndex()
    {
        $config = Setting::find()->all();

        if (\Yii::$app->request->isPost && ($saveData = \Yii::$app->request->post('data', null)) && is_array($saveData)) {
            foreach ($config as $cfgItem) {
                $data = null;
                if (($cfgItem->type === 'checkbox') && empty($saveData[$cfgItem->name])) {
                    $cfgItem->value = 0;
                } else {
                    $cfgItem->value = $saveData[$cfgItem->name] ?? null;
                }

                $cfgItem->save();
            }
            \Yii::$app->response->refresh();
        }

        return $this->render('index', [
            'config' => $config
        ]);
    }
}