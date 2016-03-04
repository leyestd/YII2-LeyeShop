<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '收货信息';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?= $this->render('@app/views/ucenter/_leftmenu') ?>
        </div>

        <div class="col-md-9">
            <?php $form = ActiveForm::begin([
            'id' => 'create-form',
            'options' => ['class' => 'form-horizontal'],
            ]) ?>

            <?= $form->field($model, 'name')->label("名称") ?>
            <?= $form->field($model, 'mobile')->label("移动电话") ?>
            <?= $form->field($model, 'phone')->label("座机&nbsp;(可为空)") ?>
            <?= $form->field($model, 'address')->label("地址") ?>
            <?= $form->field($model, 'email')->label("邮箱") ?>
            <?= $form->field($model, 'postcode')->label("邮编") ?>

            <div class="form-group">
                <?= Html::submitButton('添加', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>