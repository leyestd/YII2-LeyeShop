<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class SendConfirm extends Model
{
    public $WIDtrade_no;
    public $WIDlogistics_name;
    public $WIDinvoice_no;
    public $WIDtransport_type;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['WIDtrade_no', 'WIDlogistics_name'], 'required'],
            // rememberMe must be a boolean value
            [['WIDtrade_no', 'WIDlogistics_name','WIDinvoice_no','WIDtransport_type'], 'string', 'max' => 30],
            // password is validated by validatePassword()
        ];
    }

}
