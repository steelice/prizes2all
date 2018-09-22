<?php

namespace app\modules\api\modules\v1\controllers;


use app\components\delivery\DeliveryFactory;
use app\models\PrizeUser;
use yii\filters\AccessControl;
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

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'actions' => ['get', 'update-data', 'cancel'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];

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

    public function actionGet(): array
    {
        try {
            $myPrize = \Yii::$app->prize->takeRandom(\Yii::$app->user->identity);
        } catch (\Exception $e) {
            return ['success' => false];
        }

        return $this->prizeInfo($myPrize);
    }

    /**
     * Добавляет примечание призу от юзера
     *
     * @param $id
     * @return PrizeUser
     * @throws NotFoundHttpException
     */
    public function actionUpdateData($id): array
    {
        $prize = $this->getMyPrize($id);

        $prize->userNotes = \Yii::$app->request->post('userNotes');
        $prize->save();

        return $this->prizeInfo($prize);
    }

    /**
     * Отменяет приз юзером
     *
     * @param $id
     * @return PrizeUser
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionCancel($id): array
    {
        $prize = $this->getMyPrize($id);

        $delivery = DeliveryFactory::getDelivery($prize);

        $delivery->cancel();

        return $this->prizeInfo($prize);
    }

    /**
     * Возвращает инфу о призе с необходимыми атрибутами
     *
     * @param PrizeUser $prize
     * @return array
     */
    public function prizeInfo(PrizeUser $prize): array
    {
        if ($prize->firstErrors) {
            return [
                'success' => false,
                'errors' => $prize->firstErrors
            ];
        }
        return [
            'success' => true,
            'prize' => $prize->getAttributes(['id', 'status', 'value']),
            'type' => $prize->type->getAttributes(['name', 'title', 'description']),
            'item' => $prize->item ? $prize->item->getAttributes(['name']) : null
        ];
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