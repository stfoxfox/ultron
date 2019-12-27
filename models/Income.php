<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "income".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $template_id
 * @property string $sum
 * @property string $comment
 * @property string $created_at
 */
class Income extends \yii\db\ActiveRecord
{

    const NUMBER_LENGTH = 8;
    const HOLD_MINUTES = 14400;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'income';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'comment'], 'required'],
            [['user_id', 'template_id'], 'integer'],
            [['sum'], 'number'],
            [['comment'], 'string'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'template_id' => 'Товар',
            'sum' => 'Сумма',
            'comment' => 'Комментарий',
            'created_at' => 'Дата',
        ];
    }

    /**
     * @return string
     */
    public function getDisplayNumber()
    {
        return str_pad($this->id, self::NUMBER_LENGTH, 0, STR_PAD_LEFT);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Return whether payment on hold
     * @return boolean
     * */
    public function isOnHold()
    {
        $created_at = strtotime($this->created_at);
        $match = time() - $created_at;
        return $match < self::HOLD_MINUTES * 60;
    }
}
