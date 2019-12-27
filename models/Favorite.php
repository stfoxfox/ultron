<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "favotite".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $template_id
 *
 * @property Template $template
 * @property User $user
 */
class Favorite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'favorite';
    }

    /**
     * @param $userId
     * @param $templateId
     * @return bool
     */
    public static function isExists($userId, $templateId)
    {
        return self::find()->where([
            'user_id' => $userId,
            'template_id' => $templateId,
        ])->exists();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'template_id'], 'required'],
            [['user_id', 'template_id'], 'integer'],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Template::className(), 'targetAttribute' => ['template_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'template_id' => 'Template ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
