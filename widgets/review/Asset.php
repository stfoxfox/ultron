<?php
namespace app\widgets\review;


class Asset extends \vova07\comments\Asset
{
/**
     * @inheritdoc
     */
    public $sourcePath = '@app/widgets/review/assets';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/comments.js',
        'js/script.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset'
    ];
}