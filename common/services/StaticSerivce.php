<?php
namespace app\common\services;

// 用于加载应用本身的css,js文件
// web/js/admin/user/***
class StaticSerivce
{

    public static function includeAppJsStatic($path, $depend)
    {
        self::includeAppStatic('js', $path, $depend);
    }

    public static function includeAppCssStatic($path, $depend)
    {
        self::includeAppStatic('css', $path, $depend);
    }

    protected static function includeAppStatic($type, $path, $depend)
    {
        $release_version = defined("RELEASE_VERSION") ? RELEASE_VERSION : time();
        $path = $path . "?ver=" . $release_version;
        if ($type == "css") {
            \Yii::$app->getView()->registerCssFile($path, [
                'depends' => $depend
            ]);
        } else {
            \Yii::$app->getView()->registerJsFile($path, [
                'depends' => $depend
            ]);
        }
    }
}

