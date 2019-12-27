<?php

namespace app\modules\admin;

use yii\web\AssetBundle;

/**
 * Class AdminAsset
 * @package app\modules\admin
 */
class AdminAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/admin/assets';

    public $css = [
        'css/custom.css'
    ];
    public $js = [
        'js/jquery.maskedinput.js',
        'js/custom.js',
    ];

    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];

    public $depends = [
        'app\components\inspinia\InspiniaAsset',
    ];
}