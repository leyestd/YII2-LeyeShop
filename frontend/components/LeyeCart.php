<?php
namespace frontend\components;
use Yii;

/**
 * Description of LeyeCart
 *
 * @author Administrator
 */
class LeyeCart extends yii\base\Object{
    private $_positions=[];
    private $cartId=__Class__;
    
    public function loadFromSession() {
        $session = Yii::$app->session;
        if(isset($session[$this->cartId]))
        {
            return  unserialize($session[$this->cartId]);
        } else {
            return [];
        }
    }
    
    public function saveToSession($_positions) {
        $session = Yii::$app->session;
        $session[$this->cartId]= serialize($_positions);
    }

    public function getCount() {
        $this->_positions=  $this->loadFromSession($this->cartId);
        $count=0;
        if($this->_positions!=NULL) {
            foreach ($this->_positions as $position) {
                $count+=$position->quantity;
            }
        }
        return $count;
    }
    
    public function removeAll() {
        $this->_positions=[];
        $this->saveToSession($this->_positions);
    }
}
