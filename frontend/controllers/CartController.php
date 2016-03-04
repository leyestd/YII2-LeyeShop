<?php

namespace frontend\controllers;

use frontend\components\LeyeCart;
use frontend\models\UserForm;
use Yii;
use common\models\Order;
use frontend\models\OrderItem;
use leyestd\alipay\Alipay;
use common\models\Recipient;
use common\models\ProductSku;
use leyestd\alipay\lib\AlipaySubmit;

class CartController extends \yii\web\Controller {

    private $_positions = [];

    public function actionList() {
        $this->_positions = (new LeyeCart())->loadFromSession();

        return $this->render('list', ['positions' => $this->_positions]
        );
    }

    public function actionDelete($id) {
        $cart = new LeyeCart();
        $this->_positions = $cart->loadFromSession();
        unset($this->_positions[$id]);
        $cart->saveToSession($this->_positions);
        return $this->redirect(['cart/list']);
    }

    /*
     * status 0 未付款
     * status 10 已付款
     * 
     * logistics 0  未发货
     * logistics 10 已发货
     */
    
    public function actionOrder() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        
        $id = Yii::$app->user->id;
        $this->_positions = (new LeyeCart())->loadFromSession();
        
        $order = new Order();
        $transaction = Order::getDb()->beginTransaction();
        try {
            if ($order->load(Yii::$app->request->post()) && $order->validate()) {
                $order->status = 0;
                $order->logistics=0;
                $order->user_id = $id;
                $order->save(false);
                
                $orderNumber= date("YmdHis").$order->id;
                $order->orderNumber=$orderNumber;
                $order->save(false);
                
                $productSkus='';
                $cost=0;
                $show_url=\Yii::$app->params['showUrl'];
                
                foreach($this->_positions as $position) {
                    $productSkus = $productSkus." ".ProductSku::find()->where(['id'=>$position->id])->one()->title;
                    $orderItem=new OrderItem();
                    $orderItem->order_id=$order->id;
                    $orderItem->productSku_id=$position->id;
                    $orderItem->quantity=$position->quantity;
                    $orderItem->price=$position->price;
                    $cost += $position->price*$position->quantity;
                    if(!$orderItem->save(false)) {
                         $transaction->rollBack();
                        \Yii::$app->session->addFlash('error', 'Cannot place your order. Please contact us.');
                        return $this->redirect(['cart/list']);
                    }
                }
                
                $transaction->commit();
     
                $cart=new LeyeCart();
                $cart->removeAll();
                
               
                $recipient= Recipient::find()->where(['id'=>$order->recipient_id])->one();
                
                $alipay=new Alipay($order->orderNumber,  ltrim($productSkus),$cost,$order->notes,$show_url,$recipient->name,$recipient->address,$recipient->postcode,$recipient->phone,$recipient->mobile);

                $html_text = (new AlipaySubmit($alipay->alipay_config))->buildRequestForm($alipay->parameter, "get", "确认");
               
                echo $html_text;
                
                //\Yii::$app->session->addFlash('success', 'Thanks for your order. We\'ll contact you soon.');
                // $order->sendEmail();

                //return $this->redirect(['cart/list']);  
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        $model = new UserForm;
        $user = $model::findOne(['id' => $id]);
        $recipients = $user->recipients;

        if ($recipients == null) {
            $this->redirect(['recipient/create']);
        }

        return $this->render('order', ['positions' => $this->_positions,
                    'user' => $user,
                    'recipients' => $recipients
                        ]
        );
    }
}
