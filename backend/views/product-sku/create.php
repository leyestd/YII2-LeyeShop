<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductSku */

$this->title = 'Create Product Sku';
$this->params['breadcrumbs'][] = ['label' => 'Product Skus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-sku-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'skuInfo'=>$skuInfo,
        'skuName'=>$skuName
    ]) ?>

</div>