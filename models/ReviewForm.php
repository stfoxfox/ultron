<?php
/**
 * Created by PhpStorm.
 * User: sz
 * Date: 25.02.18
 * Time: 13:52
 */

namespace app\models;


use yii\base\Model;

class ReviewForm extends Model
{
    public $verifyCode;
    public $parent_id;
    public $model_id;
    public $model_class;
    public $content;
    public $receive_flag = 1;

    private $_model;
    private $_templateNotice;

    public function __construct(Review $model = null, array $config = [])
    {
        parent::__construct($config);
        if($model){
            $this->_model = $model;
        }
        else{
            $this->_model = new Review();
        }
    }

    public function initTemplateNotice()
    {
        if($this->_templateNotice)
            return;
        $this->_templateNotice = TemplateNotice::getByTemplateForUser($this->model_id, \Yii::$app->getUser()->getId());
        $this->_templateNotice = $this->_templateNotice ?: new TemplateNotice([
            'user_id' => \Yii::$app->getUser()->getId(),
        ]);
        $this->receive_flag = $this->_templateNotice->receive_flag !== null ? $this->_templateNotice->receive_flag : $this->receive_flag;
    }

    public function getModel()
    {
        return $this->_model;
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['content', 'required'],
            ['content', 'string'],
//            ['verifyCode', 'captcha'],
            [['receive_flag'], 'integer'],
            [['parent_id', 'model_class', 'model_id'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'receive_flag' => 'Получать уведомления на e-mail',
        ];
    }

    public function beforeValidate()
    {
        if(!parent::beforeValidate())
            return false;
        $this->initTemplateNotice();
        return true;
    }

    public function saveTemplateNotice()
    {
        $this->initTemplateNotice();
        $this->_templateNotice->template_id = $this->model_id;
        $this->_templateNotice->receive_flag = $this->receive_flag ? 1 : 0;
        return $this->_templateNotice->save();
    }
}