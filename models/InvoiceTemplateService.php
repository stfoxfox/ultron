<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoice_template_service".
 *
 * @property integer $invoice_template_id
 * @property integer $service_id
 * @property integer $price
 */
class InvoiceTemplateService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice_template_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_template_id', 'service_id', 'price'], 'required'],
            [['invoice_template_id', 'service_id', 'price'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'invoice_template_id' => 'Invoice Template ID',
            'service_id' => 'Service ID',
            'price' => 'Price',
        ];
    }

    public function getService() {
        return $this->hasOne(Service::className(), ['id' => 'service_id']);
    }
}
