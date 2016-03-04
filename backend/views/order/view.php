<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */


switch ($model->status) {
    case '111':
        $status='已删除';
        break;
    case '10':
        $status='已付款';
        break;
    default:
        $status='未付款';
        break;
};

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1>订单号：<?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('确认发货', ['send-confirm', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d H:i']
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'php:Y-m-d H:i']
            ],
            'orderNumber',
            'notes:ntext',
            [
                'attribute' => 'status',
                'value' => $status
            ],
            'logistics',
            [
                'attribute' => 'user_id',
                'value' => $model->user->username,
            ],
            [
                'attribute' => 'recipient_id',
                'value' => '<span style="margin-left:10px;margin-bottom:5px" class="btn btn-danger">姓名:' . $model->recipient->name . '</span>'
                . '<br>' . '<span style="margin-left:10px;margin-bottom:5px" class="btn btn-danger">手机:' . $model->recipient->mobile . '</span>'
                . '<br>' . '<span style="margin-left:10px;margin-bottom:5px" class="btn btn-danger">电话:' . $model->recipient->phone . '</span>'
                . '<br>' . '<span style="margin-left:10px;margin-bottom:5px" class="btn btn-danger">地址:' . $model->recipient->address . '</span>'
                . '<br>' . '<span style="margin-left:10px;margin-bottom:5px" class="btn btn-danger">邮箱:' . $model->recipient->email . '</span>'
                . '<br>' . '<span style="margin-left:10px;margin-bottom:5px" class="btn btn-danger">邮编:' . $model->recipient->postcode . '</span>',
                'format' => 'html'
            ],
            'alinumber',
            'trade_status',
            'refund_status',
            [
                'attribute' => 'experience',
                'value' => $model->getExperience(),
            ],
            'comment:ntext',
            [
                'label' => 'orderItems',
                'value' => $orderContent,
                'format' => 'html'
            ],
            [
                'label' => '总价',
                'value' => $price . '元'
            ]
        ],
    ])
    ?>

</div>
