<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sku".
 *
 * @property integer $id
 * @property string $name
 * @property string $content
 * @property integer $product_id
 *
 * @property Product $product
 * @property SkuAttr[] $skuAttrs
 */
class Sku extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sku';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'content', 'product_id'], 'required'],
            [['product_id'], 'integer'],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkuAttrs()
    {
        return $this->hasMany(SkuAttr::className(), ['sku_id' => 'id']);
    }
}
