<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Sku */

$this->title = 'Update Sku: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Skus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sku-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
