<?php
namespace backend\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the upload form.
 */
class MultipleUploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $files;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['files'], 'file', 'extensions' => 'jpg,png', 'mimeTypes' => 'image/jpeg,image/png', 'maxFiles' => 10, 'skipOnEmpty' => false],
        ];
    }
}