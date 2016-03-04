<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SkuAttr */

$this->title = 'Create Sku Attr';
$this->params['breadcrumbs'][] = ['label' => 'Sku Attrs', 'url' => ['index']];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sku-attr-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
