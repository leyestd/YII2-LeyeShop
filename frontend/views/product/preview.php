<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use frontend\assets\AppPreviewAsset;
use yii\helpers\Url;
use common\models\Sku;
use common\models\ProductSku;


AppPreviewAsset::register($this);

$this->title = '预览';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['preview', 'id' => 3]];
?>
<div class="container-fluid" style="padding-bottom: 100px;">
    <div class="row">
        <div class="col-md-4">

            <div style="padding: 5px;border:1px solid blanchedalmond">
                <div id="pic">
                    <?php
                    echo Html::img($images[0]->getThumbnailUrl(), ['width' => '100%']);
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-1" style="text-align: center;">
            <span id="moveUp" class="glyphicon glyphicon-chevron-up" style = "margin: 4px;display:block;cursor:pointer;"></span>
            <div style="height:348px;overflow:hidden;">
                <div id="myPics" style="margin-top: 4px;position: relative;" data-pics="<?=  count($images) ?>" data-pict="<?=  count($images) ?>">

                    <?php
                    foreach ($images as $img) {
                        echo Html::img($img->getThumbnailUrl(), ['id' => $img->id, 'width' => '100%', 'style' => 'cursor:pointer;margin-top: 4px;display:block;']);
                    }
                    ?> 

                </div>
            </div>
            <span id="moveDown" class="glyphicon glyphicon-chevron-down" style = "margin: 4px;display:block;cursor:pointer;"></span>
        </div>

        <div class="col-md-7">

            <h4 style="margin-left: 15px;font-weight: bold"><?= $productSku->introduce ?></h4>

            <div class="price">
                价格 <span class="add">¥ <?= $productSku->price ?></span>
                累计评论 <span class="add"> <?=$commentCount?></span>
                交易成功 <span class="add"> <?=$finishedCount?></span>
            </div>
            <hr>
            <div>
                <?php
                
                     //产品相关sku属性集
                     //$skus=Product::find()->where(['id'=>$productSku->product_id])->one()->skus;
                     $skus=Sku::find()->where(['product_id'=>$productSku->product_id])->orderBy(['id' => SORT_ASC])->all();
                     
                     //已定义的sku产品笛卡尔集
                     $skuInfo=ProductSku::find()->where(['product_id'=>$productSku->product_id,'status'=>10])->all();
                     
                     
                     $order=0;
                 ?>
                <div id="myskus"  data-skucount="<?=count($skus) ?>" style="padding-left: 32px;">
                    
                       <?php foreach ($skus as $sku ):?> 
                         <p class="skus" data-order="<?=$order++?>">
                           <b> <?=$sku->name.'：'?></b>
                     
                          <?php foreach ($sku->skuAttrs as $value):?> 
                             
                           <span class="notallow" data-content="<?=$value->content ?>">   <?=$value->name;?>   </span>
                             
                          <?php   endforeach;?>
                             <br style="clear: both">
                            </p>
                                   
                       <?php endforeach;?>

                   <br>
                  
                </div>
                <span class="count">数量</span> 
                <button id="MinusBt" style="float:left" class="btn btn-default" type="button">-</button>
                <input id="count" style="float:left;width:60px;" type="text" class="form-control" value="1">
                <button id="PlusBt" style="clear:both;margin-right:10px;" class="btn btn-default" type="button">+</button>
                &nbsp;(<span id="total" data-total="<?=$productSku->quantity?>"><?= ($productSku->quantity>0)?"有货":"缺货" ?></span>)
            </div>

            <div style="margin-top:25px;margin-left: 35px">
   
                <button id="quickbuy" data-url="<?= yii\helpers\Url::to(['product/buy','id'=>$productSku->id,'quantity'=>1]) ?>" type="button" class="btn btn-warning" style="padding:10px 35px">立即购买</button>

                <button id="updateCart" data-url="<?= yii\helpers\Url::to(['product/update-cart']) ?>" data-id="<?= $productSku->id ?>" style="padding:10px 40px" type="button" class="btn btn-danger">加入购物车</button>
                <span id="addcart" style="color: red;margin-left: 10px;display: none">添加成功</span>
            </div>

            <div style="margin-top:25px;margin-left: 35px">
                <span style="margin-right: 30px;">承诺</span>
                <?= Html::img(Yii::getAlias("@frontendWebroot") . "/images/77.jpg") ?> 
                <span style="margin-right: 30px;">7天无理由退货</span>
                <span>质量保证</span>
                <br/> <br/>
                <span style="margin-right: 30px;">支付方式</span><?= Html::img(Yii::getAlias("@frontendWebroot") . "/images/ali.png",['width'=>'80px']) ?> 
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div style="padding-left: 5px;padding-top: 40px;" role="tabpanel">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">商品详情</a></li>
                    
                    <li id="getcomment" role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">用户评论</a></li>

                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div style="padding: 20px">
                            <h4>规格参数</h4>
                            
                <?php $cc=0;?>                
                    <table id="specification">
                        <tr>
                        <?php foreach ($propductAttrs as $attr):?>
                                    
                        
                                <?php if($cc%5==0 && $cc!=0):?>
                                    </tr><tr><td><?=$attr->name ?>：<?=$attr->content ?></td>
                                <?php else:?>
                                    <td><?=$attr->name ?>：<?=$attr->content ?></td>
                                <?php endif;?>
                                 <?php $cc++;?>    
                        <?php endforeach;?>
                                    
                                  <?php if($cc==0){
                                      echo '<td>没有相关参数规格</td>';
                                  }elseif($cc%5!=0){
                                      $count=5-$cc%5;
                                      echo '<td colspan="'.$count.'"></td>';
                                  }
                                  ?> 
                                    </tr>
                            
                    </table>        
                            
                            <?= $productSku->description ?> <br>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="messages" data-url="<?=Url::to(['product/comments'])?>" data-id="<?=$productSku->id?>" data-number="0" data-status="nobody">
                        <h2>没有用户发表评论！</h2>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<script>
    var skuinfo=[
        <?php 
              foreach ($skuInfo as $info) {
                  if($info->skuinfo!=null) {
                    echo '"'.$info->skuinfo.'",';
                  }
              }
        ?>
    ];
    
    var productSku="<?=$productSku->skuinfo ?>";
    
    var current="<?=$url = Url::toRoute(['product/preview','id'=>$productSku->id]);?>";
    
    var skuattr=[
    <?php foreach ($skus as $sku ):?> 
            [     
             <?php foreach ($sku->skuAttrs as $value):?>          
                <?='"'.$value->content.'",';?>    
             <?php   endforeach;?>
              ],                     
    <?php endforeach;?>
            ];          

</script>