<?php

namespace backend\controllers;

use Yii;
use common\models\Order;
use common\models\SearchOrder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use backend\models\SendConfirm;
use leyestd\alipay\lib\AlipaySubmit;
use leyestd\alipay\Aliconfig;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SearchOrder();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->sort->defaultOrder = ['id' => 'id DESC'];

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $order = $this->findModel($id);

//         var_dump($order->orderItems);
//         
//         die();

        $orderItems = $order->orderItems;

        $order_price = 0;
        $orderContent = '';
        $price = 0;

        foreach ($orderItems as $item) {

            $order_price = $item->price;
            $price+=$order_price * $item->quantity;

            $orderContent.="<div style='clear:both'>"
                    . "<div style='float:left;margin-bottom:5px'>" . Html::img($item->productSku->images[0]->ThumbnailUrl, ['style' => 'vertical-align:middle;']) . "</div><hr>"
                    . "<div style='float:left'>"
                    . '<span style="margin-left:10px;margin-bottom:5px" class="btn btn-info">价格：' . $order_price . '元</span><br>'
                    . '<span style="margin-left:10px;margin-bottom:5px" class="btn btn-info">数量：' . $item->quantity . '个</span><br>'
                    . '<span style="margin-left:10px;margin-bottom:5px" class="btn btn-info">名称：' . $item->productSku->title . '</span><br>'
                    . '<span style="margin-left:10px;margin-bottom:5px" class="btn btn-info">库存：' . $item->productSku->quantity . '个</span><br>'
                    . "</div>"
                    . "</div>";
        }

        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'orderContent' => $orderContent,
                    'price' => $price
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Order();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//    }
//
//    /**
//     * Updates an existing Order model.
//     * If update is successful, the browser will be redirected to the 'view' page.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
//    }
//
//    /**
//     * Deletes an existing Order model.
//     * If deletion is successful, the browser will be redirected to the 'index' page.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSendConfirm($id) {
        $order = $this->findModel($id);
        $model = new SendConfirm();
        $model->WIDtrade_no=$order->alinumber;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            $alipay_config=(new Aliconfig)->getAliconfig();
            
            $parameter = array(
                "service" => "send_goods_confirm_by_platform",
                "partner" => trim($alipay_config['partner']),
                "trade_no" => $model->WIDtrade_no,
                "logistics_name" =>  $model->WIDlogistics_name,
                "invoice_no" => $model->WIDinvoice_no,
                "transport_type" => $model->WIDtransport_type,
                "_input_charset" => trim(strtolower($alipay_config['input_charset']))
            );

            //建立请求
            $alipaySubmit = new AlipaySubmit($alipay_config);
            $html_text = $alipaySubmit->buildRequestHttp($parameter);
            //解析XML
            //注意：该功能PHP5环境及以上支持，需开通curl、SSL等PHP配置环境。建议本地调试时使用PHP开发软件
            $doc = new \DOMDocument();
            $doc->loadXML($html_text);
            
            

            //请在这里加上商户的业务逻辑程序代码
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
            //解析XML
            if (!empty($doc->getElementsByTagName("alipay")->item(0)->nodeValue)) {
                //$alipay = $doc->getElementsByTagName("alipay")->item(0)->nodeValue;
               
                if($doc->getElementsByTagName("is_success")->item(0)->nodeValue=='T') {
                    $order->trade_status='WAIT_BUYER_CONFIRM_GOODS';
                    $order->save(false);
                    Yii::$app->session->setFlash('success', '确认发货操作成功');
                }else {
                    Yii::$app->session->setFlash('success', '确认发货操作失败');
                }
              
            }else {
                Yii::$app->session->setFlash('success', '确认发货操作失败');
            }

            return $this->redirect(['view', 'id' => $id]);
        } else {
            
            return $this->render('sendconfirm', [
                        'model' => $model,
                        'trade_no'=>$order->alinumber
            ]);
        }
    }

}
