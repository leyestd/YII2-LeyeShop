<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductAttrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Attrs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-attr-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            'content',
            'order',
            'product_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
