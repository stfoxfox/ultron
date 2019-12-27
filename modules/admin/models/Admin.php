<?php

namespace app\modules\admin\models;

/**
 * Class Admin
 * @package app\modules\admin\models
 */
class Admin extends \app\models\User
{
    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['username', 'email', 'password1', 'password2', 'status', 'first_name', 'last_name', 'phone', 'comment'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'first_name', 'last_name', 'email', 'status'], 'required'],
            [['username', 'first_name', 'last_name', 'phone', 'status'], 'string', 'max' => 32],
            [['status'], 'in', 'range' => array_keys(self::getStatuses())],
            [['email'], 'string', 'max' => 128],
            [['comment'], 'string', 'max' => 255],
            [['username', 'email'], 'unique'],
            [['email'], 'email'],
            ['password2', 'compare', 'compareAttribute' => 'password1'],
            ['password1', 'compare', 'compareAttribute' => 'password2'],
        ];
    }
}