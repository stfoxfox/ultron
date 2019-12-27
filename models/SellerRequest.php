<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "seller_request".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $skype
 */
class SellerRequest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seller_request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['email'], 'email'],
            [['message'], 'safe'],
            [['message', 'name', 'email', 'skype'], 'filter', 'filter' => function ($val) {
                return Html::encode($val);
            }],
            [['name'], 'string', 'max' => 30],
            [['email', 'skype'], 'string', 'max' => 40],
            [['message'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'email' => 'Email',
            'skype' => 'Skype',
        ];
    }

    public function sendEmail() {
        return Yii::$app->mailer->sellerRequest($this);
    }
}
