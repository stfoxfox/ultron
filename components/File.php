<?php

namespace app\components;

use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
 * Class File
 * @package common\ext
 */
class File
{
    /** Root path alias of images storage. */
    public static $storage = '@app/web/storage';

    /** @var string default image path. It will be used the default image
     * if the received image does not find. */
    public static $default = 'default.png';

    /** Base url of images storage. */
    public static $baseUrl = '/storage';

    /** @var int Cropped image quantity. It is needed to have
     * installed php5-imagick extension. */
    public static $quantity = 100;

    /**
     * The method returns a cropped image.
     *
     * @param string $model model of file. It will be using for storage subdir.
     * @param string $attr filename for cropping.
     * @param array $size array of needed sizes for cropping,
     * for example: [100, 200], where 100 is width and 200 is height.
     * @return string path to cropped image.
     */
    public static function src($model, $attr, array $size = [])
    {
        $name = ArrayHelper::getValue($model, $attr);
        $root = self::rootPath($name, $size);
        // if the original file does not exist
        if (!file_exists(self::rootPath($name) . $name)) {
            $name = self::$default;
            $root = self::rootPath($name, $size);
        }
        // if the image for needed size does not exist
        if (!file_exists(self::rootPath($name, $size) . $name)) {
            if (self::crop($name, $size)) {
                // todo: something is wrong...
            }
        }
        $path = str_replace(\Yii::getAlias(self::$storage), '', $root);
        return self::storageUrl() . $path . $name;
    }

    public static function img($model, $attr, array $size = [], array $options = [])
    {
        return Html::img(self::src($model, $attr, $size), $options);
    }

    /**
     * Wrapper for UploadedFile class. It is useful method because
     * it will save the file in right dir.
     * @param $model
     * @param $attribute
     * @return bool|string
     */
    public static function save($model, $attribute)
    {
        if (!($file = UploadedFile::getInstance($model, $attribute))) {
            if ($model instanceof ActiveRecord) {
                return $model->getOldAttribute($attribute);
            }
            return ArrayHelper::getValue($model, $attribute);
        }
        $name = self::uniqueName($file->extension);
        if ($file->saveAs(self::rootPath($name) . $name) !== true) {
            return false;
        }
        return $name;
    }

    private static function crop($name, array $size)
    {
        $original = self::rootPath($name) . $name;
        $new = self::rootPath($name, $size) . $name;
        if (strtolower(pathinfo($original, PATHINFO_EXTENSION)) === 'svg') {
            return copy($original, $new);
        }

        $img = Image::getImagine()->open($original);
        $imgSize = $img->getSize();
        $width = $size[0];
        $height = $size[1];

        if ($width > 0 && $height > 0) {
            if ($width > $height) {
                if ($imgSize->getWidth() > $imgSize->getHeight()) {
                    $img->resize($imgSize->heighten($height));
                } else {
                    $img->resize($imgSize->widen($width));
                }
            } else {
                if ($imgSize->getWidth() > $imgSize->getHeight()) {
                    $img->resize($imgSize->heighten($height));
                } else {
                    $img->resize($imgSize->widen($height));
                }
            }
            $img->crop(new Point(0, 0), new Box($width, $height));
        } else if ($width > 0) {
            $img->resize($imgSize->widen($width));
        } else if ($height > 0) {
            $img->resize($imgSize->heighten($height));
        }

        return $img->save($new, [
            'quality' => self::$quantity,
        ]);
    }

    private static function storageUrl()
    {
        $schema = 'http://';
        if (\Yii::$app->request->isSecureConnection) {
            $schema = 'https://';
        }
        return $schema . \Yii::$app->request->serverName . self::$baseUrl;
    }

    public static function rootPath($filename, array $size = [], $storageAlias = null)
    {
        if ($filename == '') {
            return false;
        }

        if (!$storageAlias) {
            $storageAlias = self::$storage;
        }

        $filename = basename($filename);
        $path = \Yii::getAlias($storageAlias);
        if ($filename !== self::$default) {
            $path .= DIRECTORY_SEPARATOR . substr(md5($filename), 0, 2);
            $path .= DIRECTORY_SEPARATOR . substr(md5($filename), 2, 2);
        }

        // если передан массив с размерами картинки, то вставим его в путь
        if ($size !== []) {
            $path .= DIRECTORY_SEPARATOR . implode('x', $size);
        }

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        return $path . DIRECTORY_SEPARATOR;
    }

    public static function uniqueName($ext = null)
    {
        $name = \Yii::$app->security->generateRandomString();
        if ($ext !== null)
            $name .= ".{$ext}";
        return $name;
    }
}