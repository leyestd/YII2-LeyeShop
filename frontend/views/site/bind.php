<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = '绑定';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-bind">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-md-5">
            <?php $form = ActiveForm::begin(['id' => 'form-bind']); ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'fullname') ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <div class="form-group">
                    <?= Html::submitButton('绑定', ['class' => 'btn btn-primary', 'name' => 'bind-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
         <div class="col-md-7">
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
