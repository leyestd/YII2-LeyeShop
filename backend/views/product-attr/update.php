<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductAttr */

$this->title = 'Update Product Attr: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Product Attrs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-attr-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
