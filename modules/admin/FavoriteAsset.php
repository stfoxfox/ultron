<?php

namespace app\modules\admin;

use yii\web\AssetBundle;

/**
 * Class FavoriteAsset
 * @package app\modules\admin
 */
class FavoriteAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/admin/assets';

    public $js = [
        'js/favorite.js',
    ];

    public $css = [
        'css/favorite.css'
    ];

    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}