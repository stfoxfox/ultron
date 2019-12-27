<?php

namespace app\modules\admin\models;

/**
 * Class Webmaster
 * @package app\modules\admin\models
 */
class Webmaster extends \app\models\User
{
    /**
     * @return array
     */
    public static function getPercentList()
    {
        $items = [0 => '0%'];
        foreach (range(50, 80, 5) as $k => $v) {
            $items[$v] = $v . '%';
        }
        return $items;
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => [
                'username',
                'payout_percent',
                'email',
                'password1',
                'password2',
                'status',
                'first_name',
                'last_name',
                'phone',
                'wmr',
                'wmz',
                'yandex_money',
                'comment',
                'payout_percent_type'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'first_name', 'last_name', 'phone', 'email', 'status', 'payout_percent_type'], 'required'],
            [['username', 'first_name', 'last_name', 'phone', 'status', 'wmr', 'wmz', 'yandex_money'], 'string', 'max' => 32],
            [['status'], 'in', 'range' => array_keys(self::getStatuses())],
            [['email'], 'string', 'max' => 128],
            [['comment'], 'string', 'max' => 255],
            [['username', 'email'], 'unique'],
            [['email'], 'email'],
            [['payout_percent'], 'in', 'range' => array_keys(self::getPercentList())],
            ['password2', 'compare', 'compareAttribute' => 'password1'],
            ['password1', 'compare', 'compareAttribute' => 'password2'],
            ['password1', 'passwordCheck'],
            ['payout_percent_type', 'integer']
        ];
    }
}