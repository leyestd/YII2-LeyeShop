<?php

use yii\helpers\Html;
?>

<div class="list-group">
    <a href="#" class="list-group-item disabled">
        用户中心
    </a>
    <?= Html::a('用户信息', ['ucenter/update'], ['class' => "list-group-item"]) ?>
    <?= Html::a('收货地址', ['recipient/index'], ['class' => "list-group-item"]) ?>
    <?= Html::a('已购商品', ['ucenter/order-list'], ['class' => "list-group-item"]) ?>
</div>