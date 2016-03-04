<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use common\models\ProductSku;
use frontend\assets\AppOrderAsset;
use yii\widgets\ActiveForm;

//AppOrderAsset::register($this);

$first=true;
$cost = 0;
?>
<h4>确认收货地址 </h4>
<hr>
<?php
$form = ActiveForm::begin([
    'id' => 'order-form']
) ?>
<div style="background-color: #fff0e8;border:1px solid #F00;padding: 20px;">
    <?php foreach($recipients as $recipient):?>
    <input type="radio" data-addr="<?=$recipient->id ?>" name="Order[recipient_id]" value="<?=$recipient->id?>" <?=($first?'checked="checked"':"")?>/>
        寄送至：<?=$recipient->address?>&nbsp;&nbsp; 姓名：<?=$recipient->name?>&nbsp;&nbsp;
        <?=$recipient->phone?>&nbsp;&nbsp;邮编:<?=$recipient->postcode?>
        <br>
        <?php if($first) $first=false;?>
    <?php endforeach;?>
</div>    

<div style="background-color: #f2f7ff;padding: 10px;margin-top: 10px;text-align: right">运费：<span style="font: 25px bold ;color: red;margin-left: 40px;margin-right: 30px;">¥0</span></div>

<hr>
<h4>确认定单信息</h4>
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
<?php if(!empty($positions)):?>
<?php foreach ($positions as $position): ?>
        <div class="row" style="background-color: #f2f7ff;margin-top:10px;padding: 10px;border-bottom: 1px dashed #0058e6">
            <div class="col-md-2">
    <?= Html::img(ProductSku::findOne(['id' => $position->id])->images[0]->getThumbnailUrl(), ['width' => '70%']) ?>
            </div>
            <div class="col-md-2">
    <?= ProductSku::findOne(['id' => $position->id])->title ?>
            </div>
            <div class="col-md-2">
    <?= $position->price ?>
            </div>
            <div class="col-md-2">
    <?= $position->quantity ?>
            </div>
            <div class="col-md-2">
                <?php
                $cost+=$position->price * $position->quantity;
                echo $position->price * $position->quantity;
                ?>
            </div>
            <div class="col-md-2">
    <?= Html::a('删除', ['cart/delete', 'id' => $position->id]) ?>
            </div>   

        </div>

<?php endforeach; ?>
    <div class="row" style="margin-top: 10px;padding: 10px;text-align: right">
        <div class="col-md-7" style="text-align: left">
            给卖家留言：<textarea name="Order[notes]" style="width: 400px;vertical-align: top"></textarea>
        </div>
        
        <div class="col-md-5" style="border:1px solid #F00;padding: 10px;">
                实付款:<span style="font: 30px bold ;color: red;margin-left: 50px;">¥<?= $cost ?></span>
        </div>     
    </div>
    <div class="row" style="margin-top: 10px">
        <div class="col-md-9">
        </div>
        <div class="col-md-3">
            <?= Html::submitButton('提交定单', ['class' => 'btn btn-success btn-lg btn-block', 'name' => 'order-button']) ?>
        </div>
    </div>
   <?php  endif;?>
</div>
<?php ActiveForm::end() ?>