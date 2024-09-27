<?php
namespace namwansoft\i18nManagement;

class Asset extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/namwansoft/yii2-i18n-management/assets';
    public $js = [
        't.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
