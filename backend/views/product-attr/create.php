<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ProductAttr */

$this->title = 'Create Product Attr';
$this->params['breadcrumbs'][] = ['label' => 'Product Attrs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-attr-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
