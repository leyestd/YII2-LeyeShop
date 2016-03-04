<?php

namespace frontend\controllers;

use common\models\ProductSku;
use common\models\Image;
use frontend\models\Position;
use Yii;
use frontend\components\LeyeCart;
use common\models\Order;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

class ProductController extends \yii\web\Controller {

    protected $_positions = [];
    private $cart;

    public function actionPreview($id, $skuinfo = NULL) {

        if ($skuinfo !== NULL) {

            $sku = ProductSku::find()->where(['skuinfo' => $skuinfo, 'status' => 10])->one();
            if ($sku != NULL) {
                $id = $sku->id;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }

        $productSku = ProductSku::find()->where(['id' => $id, 'status' => 10])->one();

        $images = Image::find()->where(['productSku_id' => $productSku->id])->all();

        $finished = Order::find()->where(['trade_status' => 'TRADE_FINISHED'])->joinwith('orderItems')
                        ->andwhere(['productSku_id' => $id])
                        ->andwhere(['refund_status' => NULL])->count();

        $comments = Order::find()->Where([ 'NOT', ['comment' => null]])->joinWith(['orderItems'])
                        ->andwhere(['productSku_id' => $id])->count();

        //$categoryAttrs=  \common\models\CategoryAttr::find()->where(['category_id'=>$product->category_id])->all();

        $propductAttrs = \common\models\ProductAttr::find()->where(['product_id' => $productSku->product_id])->all();

        return $this->render('preview', [
                    'productSku' => $productSku,
                    'images' => $images,
                    'commentCount' => $comments,
                    'finishedCount' => $finished,
                    //'categoryAttrs'=>$categoryAttrs,
                    'propductAttrs' => $propductAttrs
        ]);
    }

    public function actionUpdateCart() {

        $this->cart = new LeyeCart();
        $this->_positions = $this->cart->loadFromSession();
        $request = Yii::$app->request;

        $position = new Position();
        $position->id = $request->post('id');

        $sku = ProductSKU::findOne($position->id);

        if ($sku->status == 0) {
            echo \json_encode(['count' => $this->cart->getCount()]);
        } else {
            $position->price = $sku->price;
            $position->quantity = $request->post('quantity');

            if (isset($this->_positions[$position->id])) {
                $this->_positions[$position->id]->quantity = $this->_positions[$position->id]->quantity + $position->quantity;
            } else {
                $this->_positions[$position->id] = $position;
            }
            $this->cart->saveToSession($this->_positions);
            echo \json_encode(['count' => $this->cart->getCount()]);
        }
    }

    public function actionBuy() {
        $this->cart = new LeyeCart();
        $this->_positions = $this->cart->loadFromSession();
        $request = Yii::$app->request;

        $position = new Position();
        $position->id = $request->get('id');
        
        $sku = ProductSKU::findOne($position->id);
        
        if ($sku->status == 0) {
            throw new NotFoundHttpException('The requested page does not exist.');
        } 
         
        $position->price = $sku->price;
        $position->quantity = $request->get('quantity');

        if (isset($this->_positions[$position->id])) {
            $this->_positions[$position->id]->quantity = $this->_positions[$position->id]->quantity + $position->quantity;
        } else {
            $this->_positions[$position->id] = $position;
        }
        $this->cart->saveToSession($this->_positions);

        $this->redirect(['cart/list']);
    }

    public function actionComments($number = 0, $id, $experience = 0) {


        $amount = 8;
        if ($experience == 0) {
            $commentCount = Order::find()->Where([ 'NOT', ['comment' => null]])->joinWith(['orderItems'])
                            ->andwhere(['productSku_id' => $id])->count();
        } else {
            $commentCount = Order::find()->Where(['NOT', ['comment' => null]])->joinWith(['orderItems'])
                            ->andwhere(['productSku_id' => $id])->andWhere(['experience' => $experience])->count();
        }

        if ($commentCount != 0 && $commentCount > $number) {

            if ($number < 0)
                $number = 0;

            if ($experience == 0) {
                $comments = Order::find()->Where([ 'NOT', ['comment' => null]])->joinWith(['orderItems'])->joinWith(['user'])
                                ->andwhere(['productSku_id' => $id])->offset($number)->limit($amount)->orderBy(['id' => SORT_DESC])->all();
            } else {
                $comments = Order::find()->Where(['NOT', ['comment' => null]])->joinWith(['orderItems'])->joinWith(['user'])
                                ->andwhere(['productSku_id' => $id])->offset($number)->limit($amount)->orderBy(['id' => SORT_DESC])
                                ->andWhere(['experience' => $experience])->all();
            }
            $aboutComments = [];
            foreach ($comments as $comment) {
                $aboutComments[$comment->id]['name'] = Html::encode($comment->user->fullname);
                $aboutComments[$comment->id]['experience'] = Html::encode($comment->experience);
                $aboutComments[$comment->id]['comment'] = Html::encode($comment->comment);
            }

            echo \json_encode($aboutComments);
        } else {
            echo \json_encode(null);
        }
    }

}
