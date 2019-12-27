<?php
namespace app\models;


use app\models\queries\TemplateNoticeQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "template_notice".
 *
 * @property integer $template_id
 * @property integer $user_id
 * @property boolean $receive_flag
 *
 * @property TemplateFile[] $files
 */
class TemplateNotice extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%template_notice}}';
    }

    public static function find()
    {
        return new TemplateNoticeQuery(get_called_class());
    }

    public function rules()
    {
        return [
            [['template_id', 'user_id'], 'required'],
            [['template_id', 'user_id', 'receive_flag'], 'integer'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::class, ['id' => 'template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function getByTemplateForUser($template_id, $user_id)
    {
        return self::find()
            ->andWhere([
                'user_id' => $user_id,
                'template_id' => $template_id
            ])
            ->one();
    }
}