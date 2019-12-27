<?php
namespace app\models\sphinx;


use app\models\search\TemplateSearch;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\sphinx\ActiveRecord;

class Template extends ActiveRecord
{
    public $search;

    public static function indexName()
    {
        return 'template';
    }

    public function rules()
    {
        return [
            [['search'], 'safe'],
        ];
    }

    public function getSearchModel($params = [])
    {
        $templateSearch = new TemplateSearch();
        $this->load($params, "");
        if($this->search){
            $query = self::find()
            ->match(new Expression(':match', ['match' => '@(title) ' . $this->search . ' | @(description) ' . $this->search]));

            $result = $query->all();
            $templateSearch->id = ArrayHelper::getColumn($result, 'id');
            $templateSearch->id = $templateSearch->id ?: 0;
        }
        return $templateSearch;
    }
}