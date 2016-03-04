<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '用户评论';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?= $this->render('_leftmenu') ?>
        </div>

        <div class="col-md-9">
            <?php $form = ActiveForm::begin([
                 'id' => 'comment-form',
                 'options' => ['class' => 'form-horizontal'],
            ]) ?>

            <?= $form->field($model, 'experience')->radioList([1=>'好评',2=>'中评',3=>'差评'])->label("评论") ?>
            <?= $form->field($model, 'comment')->textarea()->label("内容") ?>
           

            <div class="form-group">
                <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>