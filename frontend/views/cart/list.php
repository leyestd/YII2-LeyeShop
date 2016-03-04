<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use common\models\ProductSku;

$cost=0;
?>
<h2>我的购物车</h2>
<hr>

<?php if(!empty($positions)):?>   
<div class="container-fluid">
        <div class="row">
        <div class="col-md-4">

        </div>
        <div class="col-md-2">
            单价（元）
        </div>
        <div class="col-md-2">
            数量
        </div>
        <div class="col-md-2">
            金额
        </div>
        <div class="col-md-2">
            操作
        </div>
    </div>
 
    <?php foreach ($positions as  $position):?>
    <div class="row" style="background-color: #fff8e1;margin-top:10px;padding: 10px;">
        <div class="col-md-2">
            <?=Html::img(ProductSku::findOne(['id'=>$position->id])->images[0]->getThumbnailUrl(), ['width' => '70%'])?>
        </div>
        <div class="col-md-2">
            <?=ProductSku::findOne(['id'=>$position->id])->title?>
        </div>
        <div class="col-md-2">
            <?=$position->price?>
        </div>
        <div class="col-md-2">
           <?=$position->quantity?>
        </div>
        <div class="col-md-2">
            <?php
                $cost+=$position->price*$position->quantity;
                echo $position->price*$position->quantity;
            ?>
        </div>
        <div class="col-md-2">
            <?= Html::a('删除', ['cart/delete', 'id' => $position->id]) ?>
        </div>   
        
    </div>
    
    <?php endforeach;?>
    <div class="row" style="background-color: #f5f5f5">
        <div class="col-md-7">
            
        </div>
        <div class="col-md-3">
            合计(不含运费):<span style="font: 30px bold ;color: red;margin-left: 50px;">¥<?=$cost ?></span>
        </div>
        <div class="col-md-2">
            <?= Html::a('结账', ['cart/order'], ['class' => 'btn btn-success btn-lg btn-block']) ?>
        </div>
        
    </div>
   
</div>
 <?php  else:?>
    <p style="text-align:center">购物车没有任何商品</p>
 <?php endif; ?>
