<?php

namespace app\widgets\review;

use app\models\AppealForm;
use app\models\Review;
use app\models\ReviewForm;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Json;

class Reviews extends Widget
{
    /**
     * @var \yii\db\ActiveRecord|null Widget model
     */
    public $model;

    /**
     * @var array Comments Javascript plugin options
     */
    public $jsOptions = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->model === null) {
            throw new InvalidConfigException('The "model" property must be set.');
        }

        $this->registerClientScript();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $class = $this->model;
        $class = Yii::$app->base->crc32($class::className());
        $models = Review::getTree($this->model->id, $class);
        $reviewForm = new ReviewForm(null, [
            'model_class' => $class,
            'model_id' => $this->model->id
        ]);
        $reviewForm->initTemplateNotice();

        $appealForm = new AppealForm();

        return $this->render('index', [
            'models' => $models,
            'reviewForm' => $reviewForm,
            'appealForm' => $appealForm
        ]);
    }

    /**
     * Register widget client scripts.
     */
    protected function registerClientScript()
    {
        $view = $this->getView();
        $options = Json::encode($this->jsOptions);
        Asset::register($view);
        $view->registerJs('jQuery.comments(' . $options . ');');
    }
}
