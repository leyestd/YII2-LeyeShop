<?php

use yii\widgets\LinkPager;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = '收货信息';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?= $this->render('@app/views/ucenter/_leftmenu') ?>
        </div>

        <div class="col-md-9">
            <p>
                <?= Html::a('添加',['recipient/create'], ['class' => 'btn btn-primary']) ?>
            
            </p>   
            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>姓名</th>
                        <th>手机</th>
                        <th>电话</th>
                        <th>邮箱</th>
                        <th>邮编</th>
                        <th></th>
                    </tr>
                </thead>
                <?php foreach ($models as $model) : ?>    
                        <tr>
                            <td><?= $model->name ?></td>
                            <td><?= $model->mobile ?></td>
                            <td><?= $model->phone ?></td>
                            <td><?= $model->email ?></td>
                            <td><?= $model->postcode ?></td>
                            <td>
                                <a href="<?=  Url::to(['recipient/update', 'id' => $model->id]) ?>"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;&nbsp;
                                <a href="<?=  Url::to(['recipient/delete', 'id' => $model->id]) ?>" data-confirm="Are you sure you want to delete this item?" data-method="post" ><span class="glyphicon glyphicon-remove"></span></a></td>
                        </tr>
                          
                        <tr>
                            <td colspan="5"><?= '地址：'.$model->address ?></td>
                        </tr>
                        <tr><td colspan="5">&nbsp;</td></tr>  
                    

                <?php endforeach; ?>
            </table>
            <?php
            echo LinkPager::widget([
                'pagination' => $pages,
            ]);
            ?>
        </div>
    </div>
</div>