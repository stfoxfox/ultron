<?php

namespace app\widgets\favorite;

use yii\web\AssetBundle;

class FavoriteSliderAsset extends AssetBundle
{
    /** @inheritdoc  */
    public $sourcePath = '@app/widgets/favorite/assets';

    public $css = [
        'css/favorite_slider.css'
    ];

    public $js = [
        'js/favorite_slider.js'
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        
        // 'yii\web\YiiAsset',
    ];
} 