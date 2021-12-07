<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/main.css',
        'css/notification-banner.css',
        'css/many.css',
        'css_register/mobile.header.css',
        'css/mobile.header.css', // для переопределения стилей из css_register
        'css_register/mobile.slider.css',
        'css/mobile.slider.css', // для переопределения стилей из css_register
        'css_register/mobile.footer.css',
        'css_register/mobile.controlgroup.css',
        'css/desktop.css',
        'css/mobile.css'
    ];
    public $js = [
        'js_register/test.js',
        'js_register/scripts.min.js',
        'js_register/iincheck.min.js',
        'js_register/mobile_menu_slide.js',
        'js_register/bootstrap.min.js',
        'js_register/syncStateManager.js',
        'js_register/modal.js'
//        'js/minified.css',
//        'css/notification-banner.css',
    ];
    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
