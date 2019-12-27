<?php
namespace app\models;


use app\models\queries\ReviewModelQuery;
use vova07\comments\models\Model;

class ReviewsModel extends Model
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%reviews_model}}';
    }

    public static function find()
    {
        return new ReviewModelQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            Review::deleteAll(['model_class' => $this->id]);

            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Review::class, ['model_class' => 'id']);
    }

}