<?php

namespace app\modules\manage\controllers;

use app\models\PrizeItem;
use app\models\PrizeType;
use app\models\PrizeUser;
use yii\web\Controller;

/**
 * Default controller for the `manage` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $totals = [
            'total' => PrizeUser::find()->where(['status' => PrizeUser::STATUS_SENT])->count(),
            'money' => PrizeUser::find()->where(['typeId' => PrizeType::find()->select('id')->where(['name' => PrizeType::MONEY_INDEX])->scalar()])->sum('value'),
            'bonus' => PrizeUser::find()->where(['typeId' => PrizeType::find()->select('id')->where(['name' => PrizeType::BONUS_INDEX])->scalar()])->sum('value'),
            'item' => PrizeUser::find()->where(['typeId' => PrizeType::find()->select('id')->where(['name' => PrizeType::ITEM_INDEX])->scalar()])->count(),
        ];

        $itemStat = [
            'notTaken' => PrizeItem::find()->where(['taken' => 0])->count(),
            'total' => PrizeItem::find()->count(),
        ];

        $itemStat['percent'] = $itemStat['total'] ? round($itemStat['notTaken'] / $itemStat['total'] * 100) : 0;

        return $this->render('index', ['totals' => $totals, 'itemStat' => $itemStat]);
    }
}
