<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Image */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Product', 'url' => ['product/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-view">

    <p>
       <?php 
            echo Html::img($model->getUrl()); 
       ?>
    </p>

</div>
