<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Expression;

/**
 * Class ForgotForm
 * @package app\models
 */
class ForgotForm extends Model
{
    public $usernameOrEmail;

    /**
     * @param User $user
     * @return array
     */
    public static function createNewPassword(User $user)
    {
        $user->password1 = Yii::$app->security->generateRandomString(8);
        $user->email_confirmation = Yii::$app->security->generateRandomString();
        $user->save(false);
        return Yii::$app->mailer->userForgotNewPassword($user);
    }

    /**
     * @param $key
     * @return null
     */
    public static function findUserByKey($key)
    {
        $user = User::find()->where(['recovery_key' => $key])->one();
        if ($user) {
            $user->recovery_key = null;
            $user->recovery_key_datetime = null;
            $user->save(false, ['recovery_key', 'recovery_key_datetime']);

            if (strtotime('-3600 minutes') > strtotime($user->recovery_key_datetime)) {
                return $user;
            }
        }

        return null;
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['usernameOrEmail'], 'required'],
            [['usernameOrEmail'], 'validateUsernameOrEmail'],
        ];
    }

    public function validateUsernameOrEmail($attribute)
    {
        $user = User::findByUsernameOrEmail($this->usernameOrEmail);
        if (!$user) {
            $this->addError($attribute, 'Такого пользователя не существует.');
        }
    }

    /**
     * @inheritdoc
     *
     */
    public function attributeLabels()
    {
        return [
            'usernameOrEmail' => 'Имя пользователя или email',
        ];
    }

    /**
     * @return bool
     */
    public function sendEmail()
    {
        /** @var User $user */
        $user = User::findByUsernameOrEmail($this->usernameOrEmail);
        $user->recovery_key = Yii::$app->security->generateRandomString(32);
        $user->recovery_key_datetime = new Expression('NOW()');
        $user->save(false, ['recovery_key', 'recovery_key_datetime']);

        return Yii::$app->mailer->userForgot($user);
    }
}
