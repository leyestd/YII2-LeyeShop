<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_sku".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $skucode
 * @property string $skuinfo
 * @property string $title
 * @property string $introduce
 * @property string $description
 * @property string $price
 * @property integer $quantity
 * @property integer $discount
 * @property integer $status
 *
 * @property Product $product
 */
class ProductSku extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_sku';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'title', 'introduce', 'description', 'price', 'quantity'], 'required'],
            [['product_id', 'quantity', 'discount', 'status'], 'integer'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['skucode', 'skuinfo', 'title', 'introduce'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'skucode' => 'Skucode',
            'skuinfo' => 'Skuinfo',
            'title' => 'Title',
            'introduce' => 'Introduce',
            'description' => 'Description',
            'price' => 'Price',
            'quantity' => 'Quantity',
            'discount' => 'Discount',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
    
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['productSku_id' => 'id']);
    }
}
