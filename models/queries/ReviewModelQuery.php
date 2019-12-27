<?php
namespace app\models\queries;


use app\models\ReviewsModel;
use yii\db\ActiveQuery;

class ReviewModelQuery extends ActiveQuery
{
     public function all($db = null)
    {
        return parent::all($db);
    }

    public function one($db = null)
    {
        return parent::one($db);
    }

    public function template()
    {
        $this->andWhere(
            ReviewsModel::tableName().'.name = :name',
            [
                'name' => 'app\models\Template'
            ]
        );
        return $this;
    }
}