<?php
namespace app\models;


use yii\base\Model;

class AppealForm extends Model
{
    public $template_id;
    public $verifyCode;
    public $content;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['content', 'required'],
            ['content', 'string'],
            ['verifyCode', 'captcha'],
            [['template_id'], 'safe'],
        ];
    }
}