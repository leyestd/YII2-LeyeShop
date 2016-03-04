<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Sku */

$this->title = 'Create Sku';
$this->params['breadcrumbs'][] = ['label' => 'Skus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sku-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
