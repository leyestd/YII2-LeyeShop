<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category_attr".
 *
 * @property integer $id
 * @property string $name
 * @property string $content
 * @property integer $order
 * @property integer $category_id
 *
 * @property Product $category
 */
class CategoryAttr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_attr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'content', 'category_id'], 'required'],
            [['order', 'category_id'], 'integer'],
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
            'category_id' => 'Category ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Product::className(), ['id' => 'category_id']);
    }
}
