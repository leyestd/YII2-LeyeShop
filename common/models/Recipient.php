<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "recipient".
 *
 * @property integer $id
 * @property string $phone
 * @property string $address
 * @property string $name
 * @property string $email
 * @property string $postcode
 * @property integer $user_id
 *
 * @property User $user
 */
class Recipient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recipient';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile', 'address', 'name', 'postcode'], 'required'],
            [['user_id'], 'integer'],
            [['phone','mobile', 'postcode'], 'string', 'max' => 45],
            [['address', 'email'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 50],
            ['email','email']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Phone',
            'mobile' => 'Mobile',
            'address' => 'Address',
            'name' => 'Name',
            'email' => 'Email',
            'postcode' => 'Postcode',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
