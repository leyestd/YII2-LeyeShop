<?php

namespace common\models;

use Yii;
use common\models\Order;
use frontend\models\OrderItem;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $category_id
 * @property integer $price
 * @property integer $quantity
 * @property integer $discount
 *
 * @property Image[] $images
 * @property OrderItem[] $orderItems
 * @property Category $category
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'category_id'], 'required'],
            [['category_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['introduce'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
           
            'category_id' => 'Category',
            
         
           
            'introduce' => 'Introduce'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
    
    public function getOrders() {
        return $this->hasMany(Order::className(), ['id'=>'order_id'])->via('orderItems');
    }
    
    public function getProductAtrrs() {
        return $this->hasMany(ProductAttr::className(), ['product_id'=>'id']);
    }
    
    public function getProductSkus() {
        return $this->hasMany(ProductSku::className(), ['product_id'=>'id']);
    }
    
        public function getSkus()
    {
        return $this->hasMany(Sku::className(), ['product_id'=>'id' ]);
    }
}
