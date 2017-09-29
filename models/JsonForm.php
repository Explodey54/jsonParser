<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;


class JsonForm extends Model
{
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => 'json'],
        ];
    }

    public function getContents()
    {
        $dir = Yii::getAlias('@app/uploads').'/'.$this->file->name;
        $this->file->saveAs($dir);
        $content = file_get_contents($dir);
        unlink($dir);

        return $content;
    }
}