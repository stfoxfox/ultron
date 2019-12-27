<?php

namespace app\components;

/**
 * Class User
 * @package app\components
 */
class User extends \yii\web\User
{
    /**
     * @return bool
     */
    public function getIsUser()
    {
        if (!$this->identity) {
            return false;
        }
        return $this->identity->role === \app\models\User::ROLE_USER;
    }

    /**
     * @return bool
     */
    public function getIsWebmaster()
    {
        if (!$this->identity) {
            return false;
        }
        return $this->identity->role === \app\models\User::ROLE_WEBMASTER;
    }

    /**
     * @return bool
     */
    public function getIsAdmin()
    {
        if (!$this->identity) {
            return false;
        }
        return $this->identity->role === \app\models\User::ROLE_ADMIN;
    }

    /**
     * @return array
     */
    public function getUserRoute()
    {
        switch ($this->getIdentity()->role) {
            case \app\models\User::ROLE_WEBMASTER:
                $route = '/admin/webmaster/view';
                break;
            case \app\models\User::ROLE_ADMIN:
                $route = '/admin/admin/view';
                break;
            default:
                $route = '/admin/user/view';
        }

        return [$route, 'id' => $this->id];
    }
}