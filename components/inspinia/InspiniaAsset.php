<?php

namespace app\components\inspinia;

use yii\web\AssetBundle;

/**
 * Class AppAsset
 * @package dekasoft\inspinia
 */
class InspiniaAsset extends AssetBundle
{
    /** @inheritdoc */
    public $sourcePath = '@app/components/inspinia/assets';

    /** @inheritdoc */
    public $css = [
        'css/bootstrap.min.css',
        'font-awesome/css/font-awesome.css',
        'css/animate.css',
        'css/style.min.css',
    ];

    /** @inheritdoc */
    public $js = [
        'js/bootstrap.min.js',
        'js/plugins/metisMenu/jquery.metisMenu.js',
        'js/plugins/slimscroll/jquery.slimscroll.min.js',
        'js/plugins/peity/jquery.peity.min.js',
        'js/plugins/iCheck/icheck.min.js',
        'js/inspinia.js',
    ];

    /** @inheritdoc */
    public $publishOptions = [
        'forceCopy' => false,
    ];

    /** @inheritdoc */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ];
}
