<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSkuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Skus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-sku-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

 

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
          

            'id',
           
            'skucode',
            'skuinfo',
            'title',
            // 'introduce',
            // 'description:ntext',
            // 'price',
            // 'quantity',
            // 'discount',
            [
                 'attribute' =>'status',
                 'value' => function ($model) {
                    return ($model->status===10)?'正常':"下架";
                 },
                 'filter'=>[10=>"正常",0=>"下架"]
            ],
             [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {images} {delete}',
                'buttons' => [
                    'images' => function ($url, $model, $key) {
                         return Html::a('<span class="glyphicon glyphicon glyphicon-picture" aria-hidden="true"></span>', Url::to(['image/index', 'id' => $model->id]));
                    }
                ],
            ],
            
        ],
    ]); ?>

</div>
