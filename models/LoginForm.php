<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    /** @var bool|User */
    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Не верный логин или пароль.');
            } elseif ($user->email_confirmation != null) {
                $this->addError($attribute, 'Вам необходимо подтвердить email.');
            } elseif ($user->status == User::STATUS_PENDING) {
                $this->addError($attribute, 'Ваша учетная запись ещё не была одобрена модератором.');
            } elseif ($user->status == User::STATUS_DISABLED) {
                $this->addError($attribute, 'Ваша учетная запись была заблокирована модератором.');
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'rememberMe' => 'Запомить меня'
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return $this->getUser()->login();

        }
        return false;
    }

    /**
     * @return null|User
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::find()->where([
                'username' => $this->username,
            ])->one();
        }

        return $this->_user;
    }
}
