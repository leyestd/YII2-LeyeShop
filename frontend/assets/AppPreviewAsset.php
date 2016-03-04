<?php
namespace frontend\assets;

use yii\web\AssetBundle;

class AppPreviewAsset extends AssetBundle
{   
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/preview.css',
    ];
    public $js = [
        'js/preview.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
