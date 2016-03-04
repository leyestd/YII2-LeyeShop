<?php

namespace common\models;

use Yii;
use common\models\ProductSku;
use frontend\models\OrderItem;
use yii\behaviors\TimestampBehavior;
use common\models\User;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $notes
 * @property integer $status
 * @property integer $user_id
 * @property integer $recipient_id
 *
 * @property User $user
 * @property Recipient $recipient
 * @property OrderItem[] $orderItems
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ ['status','logistics','recipient_id','experience'], 'integer'],
            [['notes','alinumber','trade_status','refund_status'], 'string'],
            [['comment'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'notes' => 'Notes',
            'status' => 'Status',
            'logistics'=>'Logistics',
            'user_id' => 'User ID',
            'recipient_id' => 'Recipient ID',
            'alinumber' => 'AliNumber',
            'trade_status'=>'Trade status',
            'refund_status'=>'Refund status'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(Recipient::className(), ['id' => 'recipient_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }
    
    public function getProductSkus() {
        return $this->hasMany(ProductSku::className(), ['id'=>'productSku_id'])->via('orderItems');
    }
    
    public function getExperience() {
        switch ($this->experience) {
            case 1:
                return '好评';
                break;
            case 2:
                return '中评';
                break;
            case 3:
                return '差评';
                break;
            default:
                return '未评价';
                break;
        }
    }
}
