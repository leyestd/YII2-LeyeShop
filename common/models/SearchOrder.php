<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;

/**
 * SearchOrder represents the model behind the search form about `common\models\Order`.
 */
class SearchOrder extends Order
{   
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'updated_at', 'status', 'logistics', 'user_id', 'recipient_id', 'experience'], 'integer'],
            [['notes','created_at','alinumber', 'trade_status', 'refund_status', 'comment','user.username'], 'safe'],
        ];
    }

    public function attributes()
    {
    // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['user.username']);
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
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        
        $query->joinWith(['user']);
        
        $dataProvider->sort->attributes['user.username'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        

        $query->andFilterWhere([
            'order.id' => $this->id,
            //'created_at' => $this->created_at,
            'FROM_UNIXTIME(order.created_at,\'%Y-%m-%d\')'=>$this->created_at,
            'updated_at' => $this->updated_at,
            'order.status' => $this->status,
            'logistics' => $this->logistics,
            'user_id' => $this->user_id,
            'recipient_id' => $this->recipient_id,
            'experience' => $this->experience,
        ]);

        $query->andFilterWhere(['like', 'notes', $this->notes])
            ->andFilterWhere(['like', 'alinumber', $this->alinumber])
            ->andFilterWhere(['like', 'trade_status', $this->trade_status])
            ->andFilterWhere(['like', 'refund_status', $this->refund_status])
            //->andFilterWhere(['like', 'order.created_at',$dd])
            ->andFilterWhere(['like', 'comment', $this->comment]);
        
        $query->andFilterWhere(['LIKE', 'user.username', $this->getAttribute('user.username')]);

        return $dataProvider;
    }
}
