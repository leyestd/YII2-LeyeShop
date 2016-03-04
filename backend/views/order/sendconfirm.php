<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SendConfirm */
/* @var $form ActiveForm */
$this->title = 'SendConfirm';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>确认发货</h1>

<div class="row">
    <div class="col-md-6">

        <div class="SendConfirm">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'WIDtrade_no')->label("支付宝交易号") ?>
            <?= $form->field($model, 'WIDlogistics_name')->label("物流公司名称") ?>
            <?= $form->field($model, 'WIDinvoice_no')->label("物流发货单号") ?>
            <?= $form->field($model, 'WIDtransport_type')->dropDownList(['POST'=>'平邮','EXPRESS'=>'快递','EMS'=>'EMS'])->label("物流运输类型") ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div><!-- SendConfirm -->
    </div>
    <div class="col-md-6"></div>
</div>