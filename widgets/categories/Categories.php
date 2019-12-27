<?php

namespace app\widgets\categories;

use app\models\Category;
use app\models\search\TemplateSearch;
use app\models\Template;
use app\models\Type;
use yii\base\Widget;

/**
 * Class Categories
 * @package app\widgets\categories
 */
class Categories extends Widget
{
    public $template;
    public $templates = [];

    /**
     * @return string
     */
    public function run()
    {
        $searchModel = new TemplateSearch();
        $searchModel->moderate_status = Template::MODERATE_STATUS_ALLOWED;
        $searchModel->search(\Yii::$app->request->get());

        if($this->templates){
            $categories = $searchModel->getAllCategories($this->templates);
            $categoryTags = $searchModel->getAllTags($this->templates);
        }
        else{
            $categories = $searchModel->findAvailableCategories();
            $categoryTags = $searchModel->findAvailableTags();
        }

//        $tags = $categoryTags;
        $tags = [];
        // если это страница шаблона, то оставим только те теги, в которых приссутствует этот шаблон
        if ($this->template) {
            foreach ($this->template->tags as $templateTag) {
                foreach ($categoryTags as $categoryTag) {
                    if ($categoryTag->id == $templateTag->id) {
                        $tags[] = $categoryTag;
                    }
                }
            }
        }
        else {
            $type = Type::find()->select('id')->where(['alias' => \Yii::$app->request->get('type')])->column();
            if ($categoryAlias = \Yii::$app->request->get('category')) {
                $category = Category::find()->where(['alias' => $categoryAlias])->one();
                if ($category) {
                    $typeSql = "AND t.type_id = :type_id";
                    // todo: оптимизировать, если будет много тегов
                    foreach ($categoryTags as $categoryTag) {
                        $sql = "
                            SELECT COUNT(*) FROM template t
                            LEFT JOIN template_tag tt ON t.id = tt.template_id
                            LEFT JOIN template_category tc ON t.id = tc.template_id
                            WHERE tc.category_id = :category_id
                            AND t.moderate_status = 'allowed'
                            AND tt.tag_id = :tag_id
                        ";
                        $params = [
                            'tag_id' => $categoryTag->id,
                            'category_id' => $category->id,
                        ];
                        if ($type) {
//                            echo "<pre>";
//                            var_dump($type);die;
                            $params['type_id'] = $type[0];
                            $sql .= $typeSql;
                        }
//                        var_dump($params);die;
                        $count = \Yii::$app->db->createCommand($sql, $params)->queryScalar();

                        if ($count) {
                            $tags[] = $categoryTag;
                        }
                    }
                }
            } else {
                $tags = $categoryTags;
            }
        }

        return $this->render('view', compact('categories', 'tags'));
    }
}