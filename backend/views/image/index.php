<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchImage */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Images';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if ($searchModel->productSku_id) : ?>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

            <?= $form->field($uploadForm, 'files[]')->fileInput(['multiple' => true]) ?>

            <button class="btn btn-primary">Upload</button>
        <?php ActiveForm::end() ?>
    <?php endif ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        
        'columns' => [
            'id',
            [   
                'attribute' => 'thumbnail',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    /** @var $model common\models\Image */
                    return Html::img($model->getThumbnailUrl());
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete} {images}',
                'buttons' => [
                    'images' => function ($url, $model, $key) {
                         return Html::a('<span class="glyphicon glyphicon glyphicon-picture" aria-hidden="true"></span>', Url::to(['image/view', 'id' => $model->id]));
                    }
                ],
            ],
        ],
    ]); ?>

</div>
