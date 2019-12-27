<?php

namespace app\models;

use yii\db\ActiveRecord;

class CommonModel extends ActiveRecord
{

    /**
     * @return string
     * */
    public function getMetaTitle() {
        return $this->meta_title ?? $this->title;
    }

    /**
     * @return string
     * */
    public function getMetaKeywords() {
        return $this->meta_keywords ?? false;
    }

    /**
     * @return string
     * */
    public function getMetaDescription() {
        return $this->meta_description ?? false;
    }

    public static function validateDeleteForm() {
        $post = \Yii::$app->request->post('Delete');
        if ($post['password'] == \Yii::$app->params['deletePassword']) {
            return $post;
        } else {
            \Yii::$app->session->setFlash('error', 'Неверный пароль');
        }
        return false;
    }

}