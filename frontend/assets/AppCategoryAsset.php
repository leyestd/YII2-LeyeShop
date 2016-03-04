<?php
namespace frontend\assets;

use yii\web\AssetBundle;

class AppCategoryAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/category.css',
    ];
    public $js = [
        'js/category.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
