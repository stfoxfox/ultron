<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_changing".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $picture
 * @property string $email
 * @property string $phone
 * @property string $skype
 * @property string $password_hash
 * @property string $default_payment_system
 * @property integer $confirmation_code
 * @property string $status
 */
class UserChanging extends \yii\db\ActiveRecord
{
    /**
     * @param $userId
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function findLast($userId)
    {
        return UserChanging::find()
            ->where(['AND',
                ['=', 'user_id', $userId],
                ['<', 'created_at', date('Y-m-d H:i:s', strtotime('+60 minutes')),]
            ])
            ->orderBy(['id' => SORT_DESC])
            ->one();
    }

    /**
     * @return string
     */
    public static function generateCode()
    {
        return str_pad(mt_rand(0, 99999999), 8, 0, STR_PAD_LEFT);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_changing';
    }

    /**
     * @return bool
     */
    public function applyChanges()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = User::findOne($this->user_id);
        $user->setAttributes([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'picture' => $this->picture,
            'email' => $this->email,
            'phone' => $this->phone,
            'skype' => $this->skype,
            'default_payment_system' => $this->default_payment_system,
            'confirmation_code' => UserChanging::generateCode(),
        ]);
        return $user->save(false);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['confirmation_code'], 'integer'],
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
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'picture' => 'Аватар',
            'email' => 'Email',
            'phone' => 'телефон',
            'skype' => 'Skype',
            'password_hash' => 'Password Hash',
            'default_payment_system' => 'Платежная система',
            'confirmation_code' => 'Код подтверждения',
            'status' => 'Статус',
        ];
    }
}
