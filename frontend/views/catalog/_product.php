<?php
use yii\helpers\Html;
use yii\helpers\Markdown;

?>
<?php 
$skus=$model->productSkus;

$psku=NULL;
foreach($skus as $sku) {
    if($sku->status !=0) {
        $psku=$sku;
        break;
    }
} 


if($skus!=null) { 
?>

<div class="col-xs-12 well">
    <div class="col-xs-2">
        <?php
        $images = $psku->images;
        if (isset($images[0])) {
            echo Html::img($images[0]->getThumbnailUrl(), ['width' => '100%']);
        }
        ?>
    </div>
    <div class="col-xs-6">
        <h2><?= Html::encode($psku->title) ?></h2>
        <?= Markdown::process($psku->introduce) ?>
    </div>

    <div class="col-xs-4 price">
        <div class="row">
            <div class="col-xs-12"> <span style="font: 20px bold;color:#FF4400">¥ <?= $psku->price ?></span></div>
            <div class="col-xs-12"><?= Html::a('查看 详情', ['product/preview', 'id' => $psku->id], ['class' => 'btn btn-success'])?></div>
        </div>
    </div>
</div>


<?php }?>