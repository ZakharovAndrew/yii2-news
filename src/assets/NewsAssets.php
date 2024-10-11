<?php
/**
 * @link https://github.com/ZakharovAndrew/yii2-user
 * @copyright Copyright (c) 2024 Zakharov Andrey
 */

namespace ZakharovAndrew\news\assets;

use yii\web\AssetBundle;

class NewsAssets extends AssetBundle
{
    public $sourcePath = '@vendor/zakharov-andrew/yii2-news/src/assets';

    public $css = [
        'css/style_v1.2.css',
    ];

    public $js = [
    //    'js/script.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap5\BootstrapAsset',
    ];
}