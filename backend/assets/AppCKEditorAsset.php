<?php
namespace backend\assets;

use yii\web\AssetBundle;

class AppCKEditorAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    
    public $js = [
        'ueditor/ueditor.config.js',
        'ueditor/ueditor.all.js'
    ];
}
