<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Sku */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Skus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sku-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        
        
        <?= Html::a('添加SKU属性', ['sku-attr/create', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
        <?= Html::a('列出SKU属性', ['sku-attr/index', 'SkuAttrSearch[sku_id]=' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'content',
            'product_id',
        ],
    ]) ?>

</div>
