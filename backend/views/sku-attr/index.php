<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SkuAttrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sku Attrs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sku-attr-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            

            'id',
            'name',
            'content',
            'sku_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
