<?php

namespace app\modules\admin\models;

/**
 * Class User
 * @package app\modules\admin\models
 */
class User extends \app\models\User
{

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['username', 'email', 'password1', 'password2', 'status', 'comment', 'first_name', 'last_name', 'phone'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'status'], 'required'],
            [['username', 'first_name', 'last_name', 'phone', 'status'], 'string', 'max' => 32],
            [['status'], 'in', 'range' => array_keys(self::getStatuses())],
            [['email'], 'string', 'max' => 128],
            [['username', 'email'], 'unique'],
            [['email'], 'email'],
            [['comment'], 'string', 'max' => 255],
            ['password2', 'compare', 'compareAttribute' => 'password1'],
        ];
    }
}