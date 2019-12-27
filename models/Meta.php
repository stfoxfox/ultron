<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "meta".
 *
 * @property integer $id
 * @property string $route
 * @property string $title
 * @property string $description
 * @property string $keywords
 */
class Meta extends ActiveRecord
{

    /** @property CommonModel $model */
    public $model;

    /** @property boolean $hasRoute */
    public $hasRoute = true;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'meta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['route', 'description', 'keywords'], 'required'],
            [['description', 'keywords'], 'string'],
            [['route'], 'string', 'max' => 50],
            [['title', 'tags'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'route' => 'Маршрут страницы',
            'title' => 'Тайтл страницы',
            'description' => 'Description',
            'keywords' => 'Keywords',
            'tags' => 'Теги'
        ];
    }

    /**
     * Returns object of current model and sets $model property if isset
     * @param string $route
     * @param null|CommonModel $model
     * @return Meta
     * */
    public static function getMeta($route, $model = null) {
        if (!$meta = self::findOne(['route' => $route])) {
            $meta = new Meta();
            $meta->hasRoute = false;
        }
        $meta->model = $model;
        return $meta;
    }

    public function getTitle() {
        return $this->hasRoute ? $this->generate('title') : Yii::$app->name;
    }

    public function getKeywords() {
        return $this->hasRoute ? $this->generate('keywords') : Yii::$app->params['defaultKeywords'];
    }

    public function getDescription() {
        return $this->hasRoute ? $this->generate('description') : Yii::$app->params['defaultDescription'];
    }

    private function generate($attribute) {
        $template = $this->$attribute;
        $tags = $this->getTags($template);
        $modelAttribute = null;
        if ($this->model) {
            $modelAttributeGetter = "getMeta" . ucfirst($attribute);
            $modelAttribute = $this->model->$modelAttributeGetter();
        }
        if($modelAttribute){
            return $modelAttribute;
        }
        if (!empty($tags[0])) {
            $replacement = $this->getReplacement($tags[1], $attribute, $modelAttribute);
            return str_replace($tags[0], $replacement, $template);
        } elseif ($template) {
            return $template;
        } else {
            return $attribute == "title" ? Yii::$app->name : Yii::$app->params['default' . ucfirst($attribute)];
        }
    }

    private function getTags($template) {
        preg_match_all('/\[(\w+)\]/', strval($template), $matches);
        return $matches;
    }

    private function getReplacement($tags, $attribute, $modelAttribute) {
        $result = [];
        $attribute = $attribute == "title" ? "meta_title" : $attribute;
        foreach ($tags as $tag) {
            if (in_array($tag, $this->model->getAvailableTags())) {
                if ($tag == $attribute) {
                    $result[] = $modelAttribute;
                } else {
                    $methodName = "getModel" . ucfirst($tag);
                    $result[] = $this->$methodName();
                }
            }
        }
        return $result;
    }

    private function getModelTitle() {
        return $this->model->title;
    }

    private function getModelCategory() {
        return $this->model->categories[0]->title;
    }

    private function getModelType() {
        return $this->model->type->title;
    }

    private function getModelPrice() {
        return $this->model->price;
    }

    private function getModelTags() {
        $tags = [];
        foreach ($this->model->tags as $tag) {
            $tags[] = $tag->title;
        }
        return implode(', ', $tags);
    }

    private function getModelContent_short() {
        return $this->model->content_short;
    }
}