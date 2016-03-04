<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\AppCKEditorAsset;
use yii\helpers\ArrayHelper;

AppCKEditorAsset::register($this);
/* @var $this yii\web\View */
/* @var $model common\models\ProductSku */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-sku-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'skucode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'skuinfo')->dropDownList(ArrayHelper::map($skuInfo, 'c2', 'c1'), ['prompt' => 'Select--'.$skuName]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'introduce')->textInput(['maxlength' => true]) ?>

    <script id="editor" type="text/plain" style="width:100%;height:500px;">
        <?=$model->description?>
    </script> 
    
    <script type="text/javascript">
        var ue = UE.getEditor('editor', {
        textarea: 'ProductSku[description]'
    });
    </script>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'discount')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([10=>"正常",0=>"下架"]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
