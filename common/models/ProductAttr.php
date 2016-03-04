<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_attr".
 *
 * @property integer $id
 * @property string $name
 * @property string $content
 * @property integer $order
 * @property integer $product_id
 *
 * @property Product $product
 */
class ProductAttr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_attr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'content', 'product_id'], 'required'],
            [['order', 'product_id'], 'integer'],
            [['name', 'content'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'content' => 'Content',
            'order' => 'Order',
            'product_id' => 'Product ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
