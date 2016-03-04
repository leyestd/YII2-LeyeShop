<?php
namespace frontend\models;

use yii\base\Object;

/**
 * Description of LeyeCart
 *
 * @author Administrator
 */
class Position extends Object{
    //put your code here
    
    private $id;
    private $price;
    private $quantity;
    
    function getId() {
        return $this->id;
    }

    function getPrice() {
        return $this->price;
    }

    function getQuantity() {
        return $this->quantity;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setQuantity($quantity) {
        $this->quantity = $quantity;
    }
    
}
