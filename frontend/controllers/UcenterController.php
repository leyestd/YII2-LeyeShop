<?php

namespace frontend\controllers;

use frontend\models\UserForm;
use yii\web\NotFoundHttpException;
use common\models\Order;

use Yii;
use common\models\Recipient;
use leyestd\alipay\Alipay;
use leyestd\alipay\lib\AlipaySubmit;

class UcenterController extends \yii\web\Controller {

    public function actionUpdate() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $id = Yii::$app->user->id;
        $user = UserForm::findOne(['id' => $id]);

        if ($user->load(\Yii::$app->request->post()) && $user->validate()) {
            if ($user->password != '') {
                $user->password_hash = \Yii::$app->security->generatePasswordHash($user->password);
            }
            $user->save(false);
            Yii::$app->session->setFlash('success', '更新成功.');
            return $this->redirect(['update', 'id' => $id]);
        } else {
            return $this->render('update', [
                        "model" => $user
            ]);
        }
    }

    public function actionOrderList() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $id = Yii::$app->user->id;

        $orders = Order::find()->where(['and', "user_id=$id", 'status!=111']);
        $countQuery = clone $orders;
        $pages = new \yii\data\Pagination(['totalCount' => $countQuery->count()]);
        $models = $orders->offset($pages->offset)->limit($pages->limit)->orderBy(['id' => SORT_DESC])->all();

        $orderItems = Order::find()->with('orderItems.productSku')->indexBy('id')->all();

        $order_price =[];
        

        foreach ($orderItems as $order) {
            $order_price[$order->id] = 0;
            foreach ($order->orderItems as $item) {
                $order_price[$order->id]+=$item->price*$item->quantity;
            }
            $order_price[$order->id] = $order_price[$order->id];
        }
        
        return $this->render('order-list', [
                    'models' => $models,
                    'pages' => $pages,
                    'price' => $order_price,
                    'orderItems'=>$orderItems
        ]);
    }
    
    public function actionOrderDelete($id) {
        $userId=Yii::$app->user->id;
        
        $order=Order::find()->where(['id'=>$id,'user_id'=>$userId])->one();
        
//        $transaction = Order::getDb()->beginTransaction();
//        try {
//             if($order!=null) {
//                 if($order->status===0) {      //未交易删除所有
//                    OrderItem::deleteAll(['order_id' => $id]);
//                    $order->delete();  
//                 }else {
//                     $order->status=111;    //已交易后删除
//                     $order->save(false);
//                 }
//                 $transaction->commit();
//             }
//             
//        } catch(\Exception $e){
//            $transaction->rollBack();
//            throw $e;
//        }
        $order->status=111;    //已交易后删除
        $order->save(false);
        return $this->redirect(['ucenter/order-list']);
    }
    
    public function actionPay($id) {
        
        $productString='';
        $cost=0;
        $show_url=\Yii::$app->params['showUrl'];
        $userId=Yii::$app->user->id;
        $order=  Order::findOne(['id'=>$id,'user_id'=>$userId]);
        
         if($order!==NULL) {
             $productSkus=$order->productSkus;
             $orderItems=$order->orderItems;
           
           foreach ($productSkus as $product) {
               $productString = $productString." ".$product->title; 
           }
            
           foreach ($orderItems as $item) {
               $cost+=$item->price*$item->quantity;
           }
           
           
           $recipient= Recipient::find()->where(['id'=>$order->recipient_id])->one();
                
           $alipay=new Alipay($order->orderNumber,  ltrim($productString),$cost,$order->notes, $show_url,$recipient->name,$recipient->address,$recipient->postcode,$recipient->phone,$recipient->mobile);

           $html_text = (new AlipaySubmit($alipay->alipay_config))->buildRequestForm($alipay->parameter, "get", "确认");
               
           echo $html_text; 
            
        }else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionComment($id) {
        
        $request = Yii::$app->request;
        $userId=Yii::$app->user->id;

        $order=  Order::findOne(['user_id'=>$userId,'id'=>$id]);
        $order->experience=1;
        
        if($order==NULL || $order->comment != NULL) throw new NotFoundHttpException('The requested page does not exist.');
        
        if($order->load(Yii::$app->request->post()) && $order->save()) {
             \Yii::$app->session->addFlash('success', '您已成功评论！');
             return $this->redirect(['ucenter/order-list']);   
        }else {
             return $this->render('comment',['model'=>$order]);
        }

    }
    
    public function actionTest() {
        if('aaa'==true) {
            echo "ok";
        }
    }

}
