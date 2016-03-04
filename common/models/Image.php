<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $path
 *
 * @property Product $product
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productSku_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'productSku_id' => 'ProductSku ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductSku()
    {
        return $this->hasOne(ProductSku::className(), ['id' => 'productSku_id']);
    }
    
        protected function getHash()
    {
        return md5($this->productSku_id . '-' . $this->id);
    }

    /**
     * @return string path to image file
     */
    public function getPath()
    {
        return Yii::getAlias('@frontend/web/images/' . $this->getHash() . '.jpg');
    }
    
    public function getThumbnailPath()
    {
        return Yii::getAlias('@frontend/web/thumbnailimages/' . $this->getHash() . '.jpg');
    }
    
    public function getUrl()
    {
        return Yii::getAlias('@frontendWebroot/images/' . $this->getHash() . '.jpg');
    }
    
    public function getThumbnailUrl()
    {
        return Yii::getAlias('@frontendWebroot/thumbnailimages/' . $this->getHash() . '.jpg');
    }
    
    public function afterDelete()
    {
        unlink($this->getPath());
        unlink($this->getThumbnailPath());
        parent::afterDelete();
    }
}
