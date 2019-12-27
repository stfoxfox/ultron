<?php
namespace app\models\queries;


use app\models\TemplateNotice;
use yii\db\ActiveQuery;

class TemplateNoticeQuery extends ActiveQuery
{
     public function all($db = null)
    {
        return parent::all($db);
    }

    public function one($db = null)
    {
        return parent::one($db);
    }

    public function receive()
    {
        $this->andWhere(
            TemplateNotice::tableName().'.receive_flag = :flag',
            [
                'flag' => true
            ]
        );
        return $this;
    }
}