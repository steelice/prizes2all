<?php

namespace app\modules\manage\controllers;

use app\components\delivery\DeliveryFactory;
use app\models\PrizeType;
use app\models\PrizeUser;
use app\models\search\PrizeUser as PrizeUserSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PrizesController implements the CRUD actions for PrizeUser model.
 */
class PrizesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PrizeUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PrizeUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionSend($id)
    {
        $prize = $this->findModel($id);
        $delivery = DeliveryFactory::getDelivery($prize);
        $delivery->delivery();

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionCancel($id)
    {
        $prize = $this->findModel($id);
        $delivery = DeliveryFactory::getDelivery($prize);
        $delivery->cancel();

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionConvertToBonus($id)
    {
        $prize = $this->findModel($id);
        if (PrizeType::MONEY_INDEX !== $prize->type->name) {
            throw new BadRequestHttpException(Yii::t('app', 'Приз этого типа нельзя сконвертировать в бонусы!'));
        }
        $delivery = DeliveryFactory::getDelivery($prize);
        $delivery->convertToBonus();

        return $this->redirect(['index']);
    }

    /**
     * Displays a single PrizeUser model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Finds the PrizeUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PrizeUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PrizeUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
