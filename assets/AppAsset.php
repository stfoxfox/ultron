<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\jui\JuiAsset;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // all pages
        //'css/font-awesome.css',
        //'css/bootstrap.css',
        //'css/jquery.fancybox.css',
        //'css/lightgallery.min.css',
        //'css/animate.css',
        //'css/jquery.jscrollpane.css',
        //'css/jquery.qtip.min.css',
        //'css/jquery.formstyler.css',
        //'css/chosen.css',
        //'css/jquery.filer.css',
        //'css/jquery.filer-dragdropbox-theme.css',
//        'http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css',

        // must be at the end
        'css/style_min.css',
        //'css/custom.css',
    ];

    public $js = [
        // all pages
//        'http://code.jquery.com/ui/1.11.4/jquery-ui.js',
        //'js/jquery.countdown.js',
        //'js/modernizr.js',
        //'js/jquery.fancybox.js',
        //'js/slick.min.js',
        //'js/lightgallery-all.min.js',
        //'js/jquery.mousewheel.js',
        //'js/jquery.jscrollpane.min.js',
//        'js/jquery.qtip.min.js',
        // custom pages
        //'js/jquery.formstyler.js',
        //'js/jquery.maskedinput.js',
        //'js/chosen.jquery.js',
        //'js/jquery.filer.js',
        //'js/jquery.filer.custom.js',

        // must be at the end
        //'js/onReady3.js',
        //'js/custom.js',
        'js/all_scripts.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
        'app\assets\QtipAsset',
        //'yii\jui\JuiAsset',
    ];
}
