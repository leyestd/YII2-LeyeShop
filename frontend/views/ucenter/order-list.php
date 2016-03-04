<?php

use yii\widgets\LinkPager;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = '已购商品';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?= $this->render('_leftmenu') ?>
        </div>

        <div class="col-md-9">
           
            <table class="table table-bordered">

                <thead>
                    <tr  style="background-color:#ff6a05">
                        <th>订单</th>
                        <th>日期</th>
                        <th width="60px;">总价</th>
                        
                        <th>状态</th>
                        
                    </tr>
                </thead>
                
           <?php if($models !=null):?>
           <?php foreach ($models as $model) : ?>         
                        <tr style="background-color: #f5f5f5">
                            <td>交易号：<br><?= ($model->alinumber!==NULL)?$model->alinumber:'无' ?>
                                <br>订单号：<br>
                            <?= $model->orderNumber ?></td>
                             <td><?= date('Y-m-d H:i',$model->created_at) ?>
                             </td>
                            <td><?= $price[$model->id] ?></td>
                            <td>                                
                            <?php 
                                if($model->refund_status==NULL) {
                                    switch ($model->trade_status) 
                                    {
                                        case 'WAIT_BUYER_PAY':
                                            echo '等待买家付款';
                                            break;
                                        case 'WAIT_SELLER_SEND_GOODS':
                                            echo '买家已付款，等待卖家发货';
                                            break;
                                        case 'WAIT_BUYER_CONFIRM_GOODS':
                                            echo '卖家已发货，等待买家确认';
                                            break;
                                        case 'TRADE_FINISHED' :
                                            echo '交易成功';
                                            break;
                                        case 'TRADE_CLOSED' :
                                            echo '交易中途关闭';
                                            break;
                                        default:
                                            echo '等待买家付款';
                                            break;
                                    }
                                }

                                switch ($model->refund_status) 
                                {
                                        case 'WAIT_SELLER_AGREE':
                                            echo '退款协议等待卖家确认中';
                                            break;
                                        case 'SELLER_REFUSE_BUYER':
                                            echo '卖家不同意协议，等待买家修改';
                                            break;
                                        case 'WAIT_BUYER_RETURN_GOODS':
                                            echo '退款协议达成，等待买家退货';
                                            break;
                                        case 'WAIT_SELLER_CONFIRM_GOODS' :
                                            echo '等待卖家收货';
                                            break;
                                        case 'REFUND_SUCCESS' :
                                            echo '退款成功';
                                            break;
                                        case 'REFUND_CLOSED' :
                                            echo '退款关闭';
                                            break;
                                 }
                                ?>
                                 <br>
                                <?php if($model->trade_status==='TRADE_FINISHED' && $model->comment==NULL):?>
                                    <a href="<?= Url::to(['ucenter/comment','id'=>$model->id]) ?>">评论</a>&nbsp;&nbsp;
                                <?php elseif($model->trade_status==='WAIT_BUYER_PAY' || $model->trade_status===NULL): ?>
                                    <a href="<?= Url::to(['ucenter/pay','id'=>$model->id]) ?>">付款</a>&nbsp;&nbsp;
                                <?php endif;?>
                                
                                <a href="<?=  Url::to(['ucenter/order-delete', 'id' => $model->id]) ?>" data-confirm="Are you sure you want to delete this item?" data-method="post">删除</a>
                            </td>  
                        </tr>
                        
                        <?php
                        $items = $orderItems[$model->id]->orderItems ;
                        ?>
                        
                        <?php foreach($items as $item) :?>

                        <tr>
                            <td> <a href="<?= Url::to(['product/preview','id'=>$item->productSku->id]) ?>"><?= Html::img($item->productSku->images[0]->ThumbnailUrl,['width' => '30%','style'=>'vertical-align:top']) ?></a>
                             &nbsp;
                             <?php
                                    $productSku=$item->productSku;
                                    echo $productSku->title;
                             ?>
                            </td>
                            <td>数量：<?=$item->quantity ?><br>价格：<?=$item->price ?></td>
                            <td><?=$item->quantity*$item->price ?></td>
                            <td>
                                简介：
                                <?php
                                    echo $productSku->introduce;
                                ?>
                            </td>
                        </tr>
                        
                        <?php  endforeach;?>
                        <tr>
                            <td colspan="4">&nbsp;</td>
                        </tr>
                        
            <?php endforeach; ?>
            <?php else:?>
                        <tr>
                            <td colspan="4" style="text-align:center;">没有订单</td>
                        </tr>
            <?php endif;?>
                
            </table>
            
            <?php
            echo LinkPager::widget([
                'pagination' => $pages,
            ]);
            ?>
            
        </div>
    </div>
</div>