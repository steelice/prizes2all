<?php

namespace app\models\search;

use app\models\PrizeUser as PrizeUserModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PrizeUser represents the model behind the search form of `app\models\PrizeUser`.
 */
class PrizeUser extends PrizeUserModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'userId', 'typeId', 'itemId', 'value'], 'integer'],
            [['createdAt', 'status', 'userNotes'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PrizeUserModel::find()->with('user', 'item', 'type');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'userId' => $this->userId,
            'createdAt' => $this->createdAt,
            'typeId' => $this->typeId,
            'itemId' => $this->itemId,
            'value' => $this->value,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'userNotes', $this->userNotes]);

        return $dataProvider;
    }
}
