<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoice_template_option".
 *
 * @property integer $invoice_template_id
 * @property integer $option_id
 * @property integer $price
 */
class InvoiceTemplateOption extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice_template_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_template_id', 'option_id', 'price'], 'required'],
            [['invoice_template_id', 'option_id', 'price'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'invoice_template_id' => 'Invoice Template ID',
            'option_id' => 'Option ID',
            'price' => 'Price',
        ];
    }

    public function getOption() {
        return $this->hasOne(Option::className(), ['id' => 'option_id']);
    }
}
