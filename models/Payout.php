<?php

namespace app\models;

use app\components\File;
use yii\web\UploadedFile;

/**
 * This is the model class for table "payout".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $sum
 * @property string $comment
 * @property string $payment_type
 * @property string $picture
 * @property string $created_at
 */
class Payout extends CommonModel
{
    const NUMBER_LENGTH = 8;

    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payout';
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        $this->file = UploadedFile::getInstance($this, 'file');
        if ($this->file === null) {
            $this->file = '';
        }
        return parent::beforeValidate();
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!empty($this->file)) {
                $this->picture = File::save($this, 'file');
                if ($this->picture === false) {
                    $this->addError('image', 'Не удалось загрузить изображение.');
                    return false;
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function getDisplayImage()
    {
        return File::img($this, 'picture', [40, 20]);
    }

    /**
     * @param bool $uid
     * @return array
     */
    public static function getPaymentTypes($uid = null)
    {
        if ($uid === null) {
            return [
                'yandex_money' => 'Яндекс.Деньги',
                'wmz' => 'Webmoney Z',
                'wmr' => 'Webmoney R',
            ];
        }

        $user = User::findOne($uid);
        if (!$user) {
            return [];
        }

        return [
            'wmr' => 'Webmoney ' . $user->wmr,
            'wmz' => 'Webmoney ' . $user->wmz,
            'yandex_money' => 'Яндекс.Деньги ' . $user->yandex_money,
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sum', 'payment_type', 'created_at'], 'required'],
            [['payment_type'], 'in', 'range' => array_keys(self::getPaymentTypes())],
            [['sum'], 'number', 'min' => 1000],
            ['sum', 'validateSum'],
            [['comment'], 'string'],
            [['payment_type'], 'string', 'max' => 32],
            [['file'], 'file', 'extensions' => 'png, jpg, jpeg'],
            ['created_at', 'filter', 'filter' => function ($value) {
                return date('Y-m-d 00:00:00', strtotime($value));
            }],
        ];
    }

    public function validateSum()
    {
        $user = User::findOne($this->user_id);
        if (!$user || $user->role !== User::ROLE_WEBMASTER) {
            $this->addError('sum', 'Не удалось проверить сумму, т.к. вебмастер не найден.');
        }
        if ($this->sum > $user->getAvailableIncome()) {
            $this->addError('sum', 'Значение превышает максимально доступную выплату для этого вебмастера.');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'displayNumber' => '№ выплаты',
            'user_id' => 'Пользователь',
            'sum' => 'Сумма',
            'comment' => 'Комментарий',
            'payment_type' => 'Способ выплаты',
            'picture' => 'Подтверждение',
            'created_at' => 'Дата',
            'displayPicture' => 'Скриншот',
            'file' => 'Скриншот',
        ];
    }

    /**
     * @return string
     */
    public function getDisplayPaymentType()
    {
        return self::getPaymentTypes($this->user_id)[$this->payment_type] ?? null;
    }

    /**
     * @return string
     */
    public function getDisplayNumber()
    {
        return str_pad($this->id, self::NUMBER_LENGTH, 0, STR_PAD_LEFT);
    }

    /**
     * @return string
     */
    public function getDisplayPicture()
    {
        return File::img($this, 'picture', [60, 30]);
    }
}
