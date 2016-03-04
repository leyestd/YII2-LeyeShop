<?php

namespace frontend\controllers;

use leyestd\alipay\lib\AlipayNotify;
use leyestd\alipay\Aliconfig;
use common\models\Order;
use yii\web\NotFoundHttpException;
use leyestd\alipay\lib\AlipayCore;

class AliReturnController extends \yii\web\Controller {

    public function beforeAction($action) {
        if ($action->id === 'notify') {
            $this->enableCsrfValidation = FALSE;
        }
        return parent::beforeAction($action);
    }

    public function actionReturned() {

        $alipayNotify = new AlipayNotify((new Aliconfig)->getAliconfig());
        $verify_result = $alipayNotify->verifyReturn();

        if ($verify_result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代码
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
            //商户订单号
            $out_trade_no = $_GET['out_trade_no'];

            //支付宝交易号

            $trade_no = $_GET['trade_no'];

            //交易状态
            $trade_status = $_GET['trade_status'];


            if ($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {

                //$userId=\Yii::$app->user->id;
                $order = Order::findOne(['orderNumber' => $out_trade_no]);

                if ($order !== NULL) {
                    $order->alinumber = $trade_no;
                    $order->status = 10;
                    $order->trade_status = $trade_status;
                    $order->save(false);
                }
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
            }
            /*
              else {
              echo "trade_status=" . $_GET['trade_status'];
              }

              echo "验证成功<br />";
              echo "trade_no=" . $trade_no;
             */
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } else {
            //验证失败
            //如要调试，请看alipay_notify.php页面的verifyReturn函数
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->redirect(['ucenter/order-list']);
    }

    public function actionNotify() {

        $alipayNotify = new AlipayNotify((new Aliconfig)->getAliconfig());
        $verify_result = $alipayNotify->verifyNotify();


        if ($verify_result) {//验证成功
            //商户订单号
            $out_trade_no = $_POST['out_trade_no'];
            //支付宝交易号
            $trade_no = $_POST['trade_no'];
            //交易状态
            $trade_status = $_POST['trade_status'];
            //退款申请
            $refund_status = isset($_POST['refund_status']) ? $_POST['refund_status'] : "";
            //$userId=\Yii::$app->user->id;


            $order = Order::findOne(['orderNumber' => $out_trade_no]);
            AlipayCore::logResult("交易状态：" . $trade_status);
            AlipayCore::logResult('退款状态' . $refund_status);
            AlipayCore::logResult('商户订单号：' . $out_trade_no);

            if ($order !== NULL) {
                if ($refund_status != "") {
                    if ($refund_status === 'WAIT_SELLER_AGREE') {
                        $order->refund_status = 'WAIT_SELLER_AGREE';
                        $order->save(false);
                        echo "success";
                    } else if ($refund_status === 'SELLER_REFUSE_BUYER') {
                        $order->refund_status = 'SELLER_REFUSE_BUYER';
                        $order->save(false);
                        echo "success";
                    } else if ($refund_status === 'WAIT_BUYER_RETURN_GOODS') {
                        $order->refund_status = 'WAIT_BUYER_RETURN_GOODS';
                        $order->save(false);
                        echo "success";
                    } else if ($refund_status === 'WAIT_SELLER_CONFIRM_GOODS') {
                        $order->refund_status = 'WAIT_SELLER_CONFIRM_GOODS';
                        $order->save(false);
                        echo "success";
                    } else if ($refund_status === 'REFUND_SUCCESS') {
                        $order->refund_status = 'REFUND_SUCCESS';
                        $order->save(false);
                        echo "success";
                    } else if ($refund_status === 'REFUND_CLOSED') {
                        $order->refund_status = 'REFUND_CLOSED';
                        $order->save(false);
                        echo "success";
                    }
                } else if ($trade_status == 'WAIT_BUYER_PAY') {
                    $order->alinumber = $trade_no;
                    $order->trade_status = $trade_status;
                    $order->save(false);

                    echo "success";  //请不要修改或删除
                } else if ($trade_status == 'WAIT_SELLER_SEND_GOODS') {
                    $order->alinumber = $trade_no;
                    $order->status = 10;
                    $order->trade_status = $trade_status;
                    $order->save(false);

                    echo "success";  //请不要修改或删除
                } else if ($trade_status == 'WAIT_BUYER_CONFIRM_GOODS') {
                    $order->logistics = 10;
                    $order->trade_status = $trade_status;
                    $order->save(false);

                    echo "success";  //请不要修改或删除
                } else if ($trade_status == 'TRADE_FINISHED') {
                    $order->trade_status = $trade_status;
                    $order->save(false);
                    echo "success";  //请不要修改或删除
                } else if ($trade_status == 'TRADE_CLOSED') {
                    $order->trade_status = $trade_status;
                    $order->save(false);
                    echo "success";  //请不要修改或删除
                } else {
                    //其他状态判断
                    echo "success";

                    //调试用，写文本函数记录程序运行情况是否正常
                    //logResult ("这里写入想要调试的代码变量值，或其他运行的结果记录");
                }
            } else {
                 AlipayCore::logResult("交易状态：订单不存在");
                echo "success";
            }
        } else {
            AlipayCore::logResult("交易状态：失败");
            //验证失败
            echo "fail";
        }
    }

}
