<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductSku */

$this->title = 'Update Product Sku: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Product Skus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-sku-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'skuInfo'=>$skuInfo,
        'skuName'=>$skuName
    ]) ?>

</div>
