<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoice_template".
 *
 * @property integer $id
 * @property integer $invoice_id
 * @property integer $template_id
 * @property integer $price
 *
 * @property Invoice $invoice
 * @property Template $template
 * @property InvoiceTemplateOption[] $invoiceOptions
 * @property InvoiceTemplateService[] $invoiceServices
 */
class InvoiceTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'invoice_id', 'template_id', 'price'], 'required'],
            [['id', 'invoice_id', 'template_id', 'price'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_id' => 'Invoice ID',
            'template_id' => 'Template ID',
            'price' => 'Цена',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceOptions()
    {
        return $this->hasMany(InvoiceTemplateOption::className(), ['invoice_template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceServices()
    {
        return $this->hasMany(InvoiceTemplateService::className(), ['invoice_template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceTemplateOptions()
    {
        return $this->hasMany(Option::className(), ['id' => 'option_id'])->via('invoiceOptions');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceTemplateServices()
    {
        return $this->hasMany(Service::className(), ['id' => 'service_id'])->via('invoiceServices');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'invoice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncome()
    {
        return $this->hasOne(Income::className(), [
            'invoice_id' => 'invoice_id',
            'template_id' => 'template_id'
        ]);
    }
}