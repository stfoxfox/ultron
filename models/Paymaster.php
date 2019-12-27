<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "paymaster".
 *
 * @property integer $LMI_SYS_PAYMENT_ID
 * @property integer $LMI_PAYMENT_NO
 * @property string $LMI_SYS_PAYMENT_DATE
 * @property string $LMI_PAYMENT_AMOUNT
 * @property string $LMI_CURRENCY
 * @property string $LMI_PAID_AMOUNT
 * @property string $LMI_PAID_CURRENCY
 * @property string $LMI_PAYMENT_METHOD
 * @property string $LMI_PAYMENT_DESC
 * @property string $LMI_HASH
 * @property string $LMI_PAYER_IDENTIFIER
 * @property string $LMI_PAYER_COUNTRY
 * @property string $LMI_PAYER_PASSPORT_COUNTRY
 * @property string $LMI_PAYER_IP_ADDRESS
 */
class Paymaster extends \yii\db\ActiveRecord
{

    const PAYMENT_FAILURE_PAGE = "payment-failure-page";
    const PAYMENT_SUCCESS_PAGE = "payment-success-page";
    const PAYMENT_SUCCESS_PENDING_PAGE = "payment-success-pending-page";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'paymaster';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['LMI_SYS_PAYMENT_ID', 'LMI_PAYMENT_NO', 'LMI_SYS_PAYMENT_DATE', 'LMI_PAYMENT_AMOUNT', 'LMI_CURRENCY', 'LMI_PAID_AMOUNT', 'LMI_PAID_CURRENCY', 'LMI_PAYMENT_METHOD', 'LMI_PAYMENT_DESC', 'LMI_HASH'], 'required'],
            [['LMI_SYS_PAYMENT_ID', 'LMI_PAYMENT_NO'], 'integer'],
            [['LMI_SYS_PAYMENT_DATE'], 'safe'],
            [['LMI_PAYER_IDENTIFIER'], 'default', 'value' => 'Paymaster не вернул номер'],  
            [['LMI_PAYMENT_AMOUNT', 'LMI_PAID_AMOUNT'], 'number'],
            [['LMI_PAYMENT_DESC'], 'string'],
            [['LMI_CURRENCY'], 'string', 'max' => 3],
            [['LMI_PAID_CURRENCY', 'LMI_PAYMENT_METHOD', 'LMI_PAYER_IDENTIFIER', 'LMI_PAYER_IP_ADDRESS'], 'string', 'max' => 50],
            [['LMI_HASH'], 'string', 'max' => 255],
            [['LMI_HASH'], 'validateHash'],
            [['LMI_PAYER_COUNTRY', 'LMI_PAYER_PASSPORT_COUNTRY'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'LMI_SYS_PAYMENT_ID' => 'Lmi  Sys  Payment  ID',
            'LMI_PAYMENT_NO' => 'Lmi  Payment  No',
            'LMI_SYS_PAYMENT_DATE' => 'Lmi  Sys  Payment  Date',
            'LMI_PAYMENT_AMOUNT' => 'Lmi  Payment  Amount',
            'LMI_CURRENCY' => 'Lmi  Currency',
            'LMI_PAID_AMOUNT' => 'Lmi  Paid  Amount',
            'LMI_PAID_CURRENCY' => 'Lmi  Paid  Currency',
            'LMI_PAYMENT_METHOD' => 'Lmi  Payment  Method',
            'LMI_PAYMENT_DESC' => 'Lmi  Payment  Desc',
            'LMI_HASH' => 'Lmi  Hash',
            'LMI_PAYER_IDENTIFIER' => 'Lmi  Payer  Identifier',
            'LMI_PAYER_COUNTRY' => 'Lmi  Payer  Country',
            'LMI_PAYER_PASSPORT_COUNTRY' => 'Lmi  Payer  Passport  Country',
            'LMI_PAYER_IP_ADDRESS' => 'Lmi  Payer  Ip  Address',
        ];
    }

    /**
     * Validates hash from system response
     * @param $attribute string
     * @param $params array
     * @return boolean
     * */
    public function validateHash($attribute, $params) {
        $array = [Yii::$app->params['payMaster']['merchantId']];
        foreach ($this->attributes as $key => $value) {
            $array[] = $value;
            if ($key == 'LMI_SIM_MODE') {
                break;
            }
        }
        $array[] = Yii::$app->params['payMaster']['secretKey'];
        $str = implode(';', $array);
        $hash = base64_encode(md5($str, true));
        Yii::$app->session->set('myHashStr', $str);
        Yii::$app->session->set('myHash', $hash);
        Yii::$app->session->set('serverHash', $this->$attribute);
        return $this->$attribute == $hash;
    }

    /**
     * @inheritdoc
     * */
    public function beforeSave($insert)
    {

        return parent::beforeSave($insert);
    }
}
