<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sku_attr".
 *
 * @property integer $id
 * @property string $name
 * @property string $content
 * @property integer $sku_id
 *
 * @property Sku $sku
 */
class SkuAttr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sku_attr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'content', 'sku_id'], 'required'],
            [['sku_id'], 'integer'],
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
            'sku_id' => 'Sku ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSku()
    {
        return $this->hasOne(Sku::className(), ['id' => 'sku_id']);
    }
}
