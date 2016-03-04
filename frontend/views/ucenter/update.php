<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '用户信息';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?= $this->render('_leftmenu') ?>
        </div>

        <div class="col-md-6">
            <?php $form = ActiveForm::begin([
                 'id' => 'update-form',
                 'options' => ['class' => 'form-horizontal'],
            ]) ?>
            <?= $form->field($model, 'fullname')->label("名称") ?>
            <?= $form->field($model, 'email')->label("邮箱") ?>
            <?= $form->field($model, 'password')->passwordInput()->label("密码") ?>
            <?= $form->field($model, 'password_repeat')->passwordInput()->label("重复密码") ?>

            <div class="form-group">
                <?= Html::submitButton('修改', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
        <div class="col-md-3">
         <?php 
            $session = Yii::$app->session;
            if($session->get("userimage")!==NULL) {
                 echo Html::img($session->get("userimage")),'<span style="margin-left:10px;font-size:20px;">'.$session->get("userinfo").'</span>';
                 
            }else {
                 echo Html::a(Html::img(Yii::getAlias("@frontendWebroot") . "/images/qq_logo.png", ['style'=>'margin-top:20px']), ['site/auth', 'authclient'=>'qq']);
            }
        ?>
        </div>
    </div>
</div>