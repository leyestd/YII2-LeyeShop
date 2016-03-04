<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductSku;

/**
 * ProductSkuSearch represents the model behind the search form about `common\models\ProductSku`.
 */
class ProductSkuSearch extends ProductSku
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'quantity', 'discount', 'status'], 'integer'],
            [['skucode', 'skuinfo', 'title', 'introduce', 'description'], 'safe'],
            [['price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = ProductSku::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'product_id' => $this->product_id,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'discount' => $this->discount,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'skucode', $this->skucode])
            ->andFilterWhere(['like', 'skuinfo', $this->skuinfo])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'introduce', $this->introduce])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
