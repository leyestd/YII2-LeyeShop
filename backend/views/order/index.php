<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchOrder */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1>订单列表</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'created_at',
                'value' => 'created_at',
                'format' => ['date', 'php:Y-m-d H:i'],
                'filter' =>  yii\jui\DatePicker::widget(['name' => 'SearchOrder[created_at]','dateFormat' => 'yyyy-MM-dd',]) ,
            ],
            //'updated_at',
            //'notes:ntext',
            //'status',
            //'logistics',
            [
                'attribute' => 'user.username',
                'label'=>'Username'
            ],
            
            //'recipient_id',
            //'alinumber',
            [
                'attribute' => 'trade_status',
                'value' => function ($model) {
                    switch ($model->trade_status) {
                        case 'WAIT_BUYER_PAY':
                            return '等待买家付款';
                            break;
                        case 'WAIT_SELLER_SEND_GOODS':
                            return '买家已付款，等待卖家发货';
                            break;
                        case 'WAIT_BUYER_CONFIRM_GOODS':
                            return '卖家已发货，等待买家确认';
                            break;
                        case 'TRADE_FINISHED' :
                            return '交易成功';
                            break;
                        case 'TRADE_CLOSED' :
                            return '交易中途关闭';
                            break;
                        default:
                            return '订单未提交到支付宝';
                            break;
                    }
                },
                'filter' => ['WAIT_BUYER_PAY' => '等待买家付款',
                    'WAIT_SELLER_SEND_GOODS' => '买家已付款，等待卖家发货',
                    'WAIT_BUYER_CONFIRM_GOODS' => '卖家已发货，等待买家确认',
                    'TRADE_FINISHED' => '交易成功',
                    'TRADE_CLOSED' => '交易中途关闭',
                   
                ]
            ],
            [
                'attribute' => 'refund_status',
                'value' => function ($model) {
                    switch ($model->refund_status) {
                        case 'WAIT_SELLER_AGREE':
                            return '退款协议等待卖家确认中';
                            break;
                        case 'SELLER_REFUSE_BUYER':
                            return '卖家不同意协议，等待买家修改';
                            break;
                        case 'WAIT_BUYER_RETURN_GOODS':
                            return '退款协议达成，等待买家退货';
                            break;
                        case 'WAIT_SELLER_CONFIRM_GOODS' :
                            return '等待卖家收货';
                            break;
                        case 'REFUND_SUCCESS' :
                            return '退款成功';
                            break;
                        case 'REFUND_CLOSED' :
                            return '退款关闭';
                            break;
                        default:
                            return '买家没有操作';
                            break;
                    }
                },
                'filter' => ['WAIT_SELLER_AGREE' => '退款协议等待卖家确认中',
                    'SELLER_REFUSE_BUYER' => '卖家不同意协议，等待买家修改',
                    'WAIT_BUYER_RETURN_GOODS' => '退款协议达成，等待买家退货',
                    'WAIT_SELLER_CONFIRM_GOODS' => '等待卖家收货',
                    'REFUND_SUCCESS' => '退款成功',
                    'REFUND_CLOSED'=>'退款关闭'
                ]
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                     switch ($model->status) {
                        case '111':
                            return '已删除';
                            break;
                        case '10':
                            return '已付款';
                            break;
                        default:
                            return '未付款';
                            break;
                    }
                },
                'label' => '状态',
                'filter' => ['111' => '已删除',
                             '10' => '已付款',
                             '0' => '未付款'
                ]
            ],
            //'experience',
            //'comment',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                
            ],
        ],
    ]);
    ?>

</div>
