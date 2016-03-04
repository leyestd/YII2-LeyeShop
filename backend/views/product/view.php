<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\product */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

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
        
         <?= Html::a('添加属性', ['product-attr/create', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
        <?= Html::a('列出属性', ['product-attr/index', 'ProductAttrSearch[product_id]=' => $model->id], ['class' => 'btn btn-primary']) ?>
    
        <?= Html::a('添加SKU属性', ['sku/create', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
        <?= Html::a('列出SKU属性', ['sku/index', 'SkuSearch[product_id]=' => $model->id], ['class' => 'btn btn-primary']) ?>
        
        <?= Html::a('添加SKU', ['product-sku/create', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
        <?= Html::a('列出SKU', ['product-sku/index', 'ProductSkuSearch[product_id]=' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'introduce',
//            [                      // the owner name of the model
//                 'label' => 'description',
//                 'value' => $model->description,
//                 'format' => 'text',      
//            ],
           
            [
                'label' =>'Category',
                'value' => $model->category->title
            ],
           
        ],
    ]) ?>

</div>
