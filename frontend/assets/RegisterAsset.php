<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class RegisterAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css_register/variables.css',
        'css_register/main.min.css',
        'css_register/index.css?v=3',
        'css_register/mobile.header.css',
        'css_register/mobile.slider.css',
        'css_register/mobile.content.css',
        'css_register/text.css',
        'css_register/mobile.controlgroup.css',
        'css_register/mobile.modal.css',
        'css_register/accept.css',
        'css_register/mobile.footer.css',
        'css_register/ui_custom.css',
        'css_register/loan.css',
        'css_register/card.css',
        'css_register/bootstrap.utils.css',
        'css/cookie.css'
    ];
    public $js = [
//        'js/js_register/common.js',
        'js_register/test.js',
        'js_register/scripts.min.js',
        'js_register/iincheck.min.js',
        'js_register/mobile_menu_slide.js',
        'js_register/bootstrap.min.js',
        'js_register/syncStateManager.js',
        'js_register/modal.js',
        'js/cookie.js'
    ];
    public $depends = [
//        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
