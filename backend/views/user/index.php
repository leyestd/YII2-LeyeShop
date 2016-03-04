<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Forms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-form-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'username',
            'fullname',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return ($model->status===10)?'正常':"禁用";
                 },
                'filter'=>[10=>"正常",0=>"禁用"]
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d H:m']
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'php:Y-m-d H:m'],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
