<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SkuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Skus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sku-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'content',
            'product_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
