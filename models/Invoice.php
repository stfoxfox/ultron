<?php

namespace app\models;

use kroshilin\yakassa\OrderInterface;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "invoice".
 *
 * @property integer $id
 * @property integer $template_id
 * @property integer $user_id
 * @property string $user_email
 * @property integer $sum
 * @property string $paid_at
 * @property string $token
 * @property string $created_at
 * @property string $status
 *
 * @property User $user
 * @property invoiceTemplate[] $invoiceTemplates
 *
 */
class Invoice extends ActiveRecord implements OrderInterface
{
    const NUMBER_LENGTH = 8;

    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_CANCELED = 'canceled';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'В обработке',
            self::STATUS_PAID => 'Оплачен',
            self::STATUS_CANCELED => 'Анулировано',
        ];
    }

    /**
     * Осуществить выплату авторам всех шаблонов, которые присутствуют в заказе.
     */
    public function sell()
    {
        if ($this->status !== self::STATUS_PENDING) {
            return false;
        }

        $this->paid_at = new Expression('NOW()');
        $this->status = self::STATUS_PAID;
        if ($this->save(false, ['paid_at', 'status'])) {
            // todo: что-то пошло не так
        }

        $this->user->updateCounters(['purchases_count' => 1]);
        foreach ($this->invoiceTemplates as $invoiceTemplate) {
            $invoiceTemplate->template->user->updateCounters(['sales_count' => 1]);
            $invoiceTemplate->template->updateCounters(['sales_count' => 1]);

            $payoutSum = $invoiceTemplate->template->user->calculateIncomeSum($invoiceTemplate->template->actualPrice);

            (new Income([
                'user_id' => $invoiceTemplate->template->user_id,
                'invoice_id' => $this->id,
                'template_id' => $invoiceTemplate->template_id,
                'sum' => $payoutSum,
            ]))->save(false);

            Yii::$app->mailer->invoicePaid($this->user);
            try {
                Yii::$app->mailer->productSoldWebmaster($invoiceTemplate->template, $this);
            } catch (\Exception $e) {
                $test = new Test();
                $test->title = "invoice test";
                $test->time = time();
                ob_start();
                print_r($e->getMessage());
                var_dump($e);
                $test->value = ob_get_clean();
                $test->save(false);
            }
        }
        Yii::$app->mailer->productSoldAdmin($this);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_id'], 'required'],
            [['template_id', 'user_id', 'price'], 'integer'],
            [['paid_at', 'created_at'], 'safe'],
            [['user_email', 'webmaster_percent'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'displayNumber' => '№ платежа',
            'template_id' => 'Товар',
            'template.displayArticle' => 'Артикул товара',
            'template.title' => 'Название товара',
            'template.user.username' => 'Вебмастер',
            'user.username' => 'Покупатель',
            'user_id' => 'Пользователь',
            'user_email' => 'Почта',
            'sum' => 'Сумма',
            'webmasterIncomePercent' => 'Партнерский процент',
            'webmasterIncome' => 'Сумма партнера',
            'paid_at' => 'Оплачено',
            'created_at' => 'Дата',
            'serviceIncome' => 'Прибыль',
            'displayStatus' => 'Статус',
            'status' => 'Статус',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($insert) {
            $this->token = Yii::$app->security->generateRandomString(32);
        }
        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceTemplates()
    {
        return $this->hasMany(InvoiceTemplate::className(), ['invoice_id' => 'id']);
    }

//    public function getInvoiceTemplate

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return string
     */
    public function getDisplayNumber()
    {
        return str_pad($this->id, self::NUMBER_LENGTH, 0, STR_PAD_LEFT);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ]);
    }

    /**
     * @return mixed|null
     */
    public function getDisplayStatus()
    {
        return self::getStatuses()[$this->status] ?? null;
    }

    /**
     * @return string
     */
    public function getDisplayUsername()
    {
        if ($this->user) {
            return $this->user->username;
        }
        return $this->user_email;
    }

    /**
     * @return integer
     * */
    public function getTotalPrice() {
        return $this->sum;
    }

    /**
     * @return integer
     * */
    public function getId() {
        return $this->id;
    }

    /**
     * @param $paymentType string
     * @return string
     * */
    public function getPaymentRoute($paymentType) {
        $routeList = [
            'yandex' => '/ya-kassa/order-check'
        ];
        return $routeList[$paymentType] ?? false;
    }

    /**
     * Lists descriptions of templates
     * @return string
     * */
    public function getDescrList() {
        $invoiceTemplates = $this->invoiceTemplates;
        $descr = [];
        foreach ($invoiceTemplates as $key => $template) {
            $descr[] = $template->template->title;
            if ($template->invoiceOptions) {
                foreach ($template->invoiceOptions as $option) {
                    $descr[] = $option->option->title . ' для ' . $template->template->title;
                }
            }
            if ($template->invoiceServices) {
                foreach ($template->invoiceServices as $service) {
                    $descr[] = $service->service->title . ' для ' . $template->template->title;
                }
            }
        }
        return implode(', ', $descr);
    }

    /**
     * Returns Invoice object if request is valid
     * @return Invoice|false
     * */
    public static function compareSuccess($get) {
        $invoice = Invoice::findOne($get['LMI_PAYMENT_NO']);
        $response = Paymaster::findOne($get['LMI_SYS_PAYMENT_ID']);
        if ($response) {
            $get['LMI_SYS_PAYMENT_DATE'] = str_replace('T', ' ', $get['LMI_SYS_PAYMENT_DATE']);
            $isValid = true;
            $errors = [];
            $checkArray = [
                'LMI_MERCHANT_ID' => Yii::$app->params['payMaster']['merchantId'],
                'LMI_PAYMENT_NO' => $response['LMI_PAYMENT_NO'],
                'LMI_SYS_PAYMENT_ID' => $response['LMI_SYS_PAYMENT_ID'],
                'LMI_PAYMENT_AMOUNT' => $response['LMI_PAYMENT_AMOUNT'],
                'LMI_CURRENCY' => $response['LMI_CURRENCY'],
            ];
            foreach ($checkArray as $key => $item) {
                if ($item != $get[$key]) {
                    $isValid = false;
                    $errors[] = $key;
                }
            }
            if ($isValid) {
                return [$invoice, true];
            } else {
                return $errors;
            }
        }
        return [$invoice, false];
    }
}
