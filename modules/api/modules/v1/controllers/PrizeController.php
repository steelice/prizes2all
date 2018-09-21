<?php

namespace app\modules\api\modules\v1\controllers;


use app\components\delivery\DeliveryFactory;
use app\models\PrizeUser;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class PrizeController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'get' => ['POST'],
                'update-data' => ['POST'],
                'cancel' => ['POST']
            ],
        ];

        return $behaviors;
    }

    public function actionGet()
    {
        $myPrize = \Yii::$app->prize->takeRandom(\Yii::$app->user->identity);
        $myPrize->getType();

        return $myPrize;
    }

    /**
     * Добавляет примечание призу от юзера
     *
     * @param $id
     * @return PrizeUser
     * @throws NotFoundHttpException
     */
    public function actionUpdateData($id): PrizeUser
    {
        $prize = $this->getMyPrize($id);

        $prize->userNotes = \Yii::$app->request->post('userNotes');
        $prize->save();

        return $prize;
    }

    /**
     * Отменяет приз юзером
     *
     * @param $id
     * @return PrizeUser
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionCancel($id): PrizeUser
    {
        $prize = $this->getMyPrize($id);

        $delivery = DeliveryFactory::getDelivery($prize);

        $delivery->cancel();

        return $prize;
    }

    /**
     * Возвращает приз по ID с проверкой владельца
     *
     * @param $id
     * @return PrizeUser
     * @throws NotFoundHttpException
     */
    public function getMyPrize($id): PrizeUser
    {
        $myPrize = PrizeUser::findOne(['id' => $id, 'userId' => \Yii::$app->user->id]);

        if (!$myPrize) {
            throw new NotFoundHttpException();
        }

        return $myPrize;
    }
}