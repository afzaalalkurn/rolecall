<?php

namespace frontend\assets;

use yii;
use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/custome.css',		
		'css/font-awesome.min.css',
		'css/jquery.bxslider.css',
		'css/animate.css',
		'css/lightbox.css',
        'https://fonts.googleapis.com/css?family=Lato:400,700',
		'https://fonts.googleapis.com/css?family=Roboto+Condensed',
    ];
    public $js = [
		'js/jquery.bxslider.js',
		'js/lightbox.min.js',
		'js/wow.js',
        'js/index.js'
	];
	
	
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\web\YiiAsset',
    ];

    public function init()
    {
        parent::init(); 
    }
}
