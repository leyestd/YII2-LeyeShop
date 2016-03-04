<?php

use yii\widgets\ListView;
use yii\helpers\Html;
use frontend\assets\AppCategoryAsset;

/* @var $this yii\web\View */
AppCategoryAsset::register($this);
?>


<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="#" class="list-group-item disabled">
                    商品分类
                </a>
                    <?php $t=TRUE;?>
                    <?php foreach ($categories as $category): ?>  
                        <?php if ($category->parent_id == NULL) : ?>
                            <?php
                            if ($t) {
                                $t=FALSE;
                            }else {
                                echo '</div>';
                            }
                            ?>
                            <?= Html::a($category->title, ['catalog/list', 'id' => $category->id], ['class' => "list-group-item category","data-id"=>$category->id]) ?>
                            <div id="category<?=$category->id?>" class="children">
                        <?php else:?>
                                    <?= Html::a($category->title, ['catalog/list', 'id' => $category->id],['class'=>'btn btn-info','style'=>'margin:5px;']) ?>                   
                        <?php endif ?>

                    <?php endforeach; ?>
                    <?php if(!$t) echo '</div>';?>
     
            </div>
        </div>
        <div id="right" class="col-md-9">
            <?=
            ListView::widget([
                'dataProvider' => $productsDataProvider,
                'itemView' => '_product',
            ])
            ?>
        </div>
    </div>
</div>