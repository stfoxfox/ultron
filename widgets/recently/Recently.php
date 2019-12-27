<?php

namespace app\widgets\recently;

use app\models\FavoriteTemplate;
use app\models\Template;
use yii\data\ActiveDataProvider;

/**
 * Class Recently
 * @package app\widgets\topmenu
 */
class Recently extends \yii\base\Widget
{
    /**
     * @return string
     */
    public function run()
    {
        $query = Template::find()
            ->andWhere(['id' => FavoriteTemplate::find()->select('template_id')])
            ->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
            'pagination' => false,
        ]);

        $lastTemplateQuery = Template::find()
            ->andWhere(['moderate_status' => Template::MODERATE_STATUS_ALLOWED])
            ->orderBy(['order' => SORT_ASC, 'created_at' => SORT_DESC])
            ->limit(12);

        $lastTemplateDataProvider = new ActiveDataProvider([
            'query' => $lastTemplateQuery,
            'sort' => false,
            'pagination' => false,
        ]);

        return $this->render('view', compact('dataProvider', 'lastTemplateDataProvider'));
    }
}