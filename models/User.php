<?php

namespace app\models;

use app\components\Mailer;
use himiklab\yii2\recaptcha\ReCaptchaValidator3;
use Yii;
use yii\base\ErrorException;
use yii\base\NotSupportedException;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $picture
 * @property string $email
 * @property string $phone
 * @property string $skype
 * @property string $sales_count
 * @property string $password_hash
 * @property string $access_token
 * @property string $auth_key
 * @property string $role
 * @property string $wmz
 * @property string $wmr
 * @property string $yandex_money
 * @property string $ip
 * @property string $created_at
 * @property string $last_visit
 * @property string $email_confirmation
 * @property string $payout_percent
 * @property string $payout_percent_type
 * @property string $status
 *
 * @property Comment[] $comments
 * @property Favorite[] $favorites
 * @property Template[] $templates
 * @property TemplateNotice[] $templateNotices
 *
 * @property int $dynamicIncomePercent
 */
class User extends CommonModel implements IdentityInterface
{
    const ROLE_DEFAULT = 'user';

    const SCENARIO_REGISTER_USER = 'register-user';
    const SCENARIO_REGISTER_WEBMASTER = 'register-webmaster';
    const SCENARIO_SETTINGS_USER = 'settings-user';
    const SCENARIO_ADMIN = 'admin';

    const ACCESS_TOKEN_LENGTH = 32;

    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';
    const ROLE_WEBMASTER = 'webmaster';

    const STATUS_ENABLED = 'enabled';
    const STATUS_DISABLED = 'disabled';
    const STATUS_PENDING = 'pending';

    const MIN_PASSWORD_LENGTH = 8;

    const PERCENT_TYPE_DYNAMIC = 0;
    const PERCENT_TYPE_STATIC = 1;

    public $isAgree = false;
    public $password1 = ''; // new password
    public $password2 = ''; // confirm password
    public $currentPassword = '';
    public $isPasswordChanged = false;
    public $settingsCode = '';
    public $usernameOrEmail;

    public $reCaptcha;

    /**
     * @param $usernameOrEmail
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function findByUsernameOrEmail($usernameOrEmail)
    {
        if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
            return self::find()->where(['email' => $usernameOrEmail])->one();
        } else {
            return self::find()->where(['username' => $usernameOrEmail])->one();
        }
    }

    /**
     * @param $email
     * @return bool|mixed
     */
    public static function uniqueUsername($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $username = preg_replace('/[^\w\d]/ui', '', substr($email, 0, strpos($email, '@')));
        $user = User::find()
            ->where(['LIKE', 'username', "{$username}%", false])
            ->orderBy([new Expression('length(username) DESC'), 'username' => SORT_DESC])
            ->one();

        if ($user) {
            if (preg_match('/([\d]+)$/', $user->username, $matches)) {
                $username = $username . ($matches[1] + 1);
            } else {
                $username = $username . '_' . time();
            }
        }

        return $username;
    }

    /**
     * @return string
     */
    public static function generateCode()
    {
        return str_pad(mt_rand(0, 9999), 4, 0, STR_PAD_LEFT);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * Метод возвращает список ролей.
     * @return array
     */
    public static function getRoles()
    {
        return [
            self::ROLE_ADMIN => 'Админ',
            self::ROLE_USER => 'Пользователь',
            self::ROLE_WEBMASTER => 'Вебмастер',
        ];
    }

    /**
     * Метод возвращает список ролей.
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_ENABLED => 'Активен',
            self::STATUS_DISABLED => 'Не активен',
            self::STATUS_PENDING => 'На модерации',
        ];
    }

    /**
     * Метод возвращает название элемента.
     * @param $key
     * @return mixed|null
     */
    public static function getRoleLabel($key)
    {
        $items = self::getRoles();
        return isset($items[$key]) ? $items[$key] : null;
    }

    /**
     * @param $sum
     * @return float
     */
    public function calculateIncomeSum($sum)
    {
        $percent = $this->incomePercent();
        if ($percent > 0 && $sum > 0) {
            return $sum / 100 * $percent;
        }
        return 0;
    }

    /**
     * @return int
     */
    public function incomePercent()
    {
        if ($this->payout_percent_type == self::PERCENT_TYPE_DYNAMIC) {
            $percent = $this->getDynamicIncomePercent();
        } else {
            $percent = $this->payout_percent;
        }
        return $percent;
    }

    /**
     * @return int
     * */
    public function getDynamicIncomePercent()
    {
        if ($this->sales_count < 50) {
            $percent = 50;
        } else {
            if ($this->sales_count < 100) {
                $percent = 60;
            } else {
                $percent = 70;
            }
        }
        return $percent;
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_REGISTER_USER => [
                'username',
                'first_name',
                'last_name',
                'email',
                'password1',
                'password2',
                'isAgree',
                'reCaptcha',
            ],
            self::SCENARIO_SETTINGS_USER => [
                'username',
                'settingsCode',
                'first_name',
                'last_name',
                'email',
                'currentPassword',
                'password1',
                'password2',
                'currentPassword',
                'phone',
                'default_payment_system',
            ],
            self::SCENARIO_REGISTER_WEBMASTER => [
                'username',
                'first_name',
                'last_name',
                'email',
                'phone',
                'skype',
                'password1',
                'password2',
                'wmr',
                'wmz',
                'yandex_money',
                'isAgree',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [
                ['username', 'email', 'password1', 'password2', 'isAgree'],
                'required',
                'on' => self::SCENARIO_REGISTER_USER,
            ],
            [['settingsCode', 'username', 'email'], 'required', 'on' => self::SCENARIO_SETTINGS_USER],
            ['settingsCode', 'validateSettingsCode'],
            [
                ['username', 'email', 'phone', 'password1', 'password2', 'isAgree'],
                'required',
                'on' => self::SCENARIO_REGISTER_WEBMASTER,
            ],
            [
                ['isAgree'],
                'required',
                'requiredValue' => 1,
                'on' => [self::SCENARIO_REGISTER_WEBMASTER, self::SCENARIO_REGISTER_USER],
                'message' => 'Вы должны согласиться с правилами и условиями.',
            ],
            [
                ['username', 'first_name', 'last_name', 'phone', 'role', 'wmz', 'wmr', 'yandex_money', 'ip'],
                'string',
                'max' => 32,
            ],
            [['email', 'skype'], 'string', 'max' => 128],
            [['username', 'email'], 'unique'],
            ['default_payment_system', 'in', 'range' => array_keys(Payout::getPaymentTypes())],
            [['email'], 'email'],
            ['password2', 'compare', 'compareAttribute' => 'password1'],
            ['currentPassword', 'validateCurrentPassword'],
            [
                ['currentPassword'],
                'required',
                'when' => function () {
                    return $this->password1 != null || $this->password2 != null;
                },
            ],
            ['password1', 'passwordCheck'],
            ['payout_percent_type', 'integer'],
        ];
        if (!Yii::$app->request->isAjax) {
            $rules[] = [
                ['reCaptcha'],
                ReCaptchaValidator3::className(),
                'threshold' => 0.5,
                'action' => false,
                'on' => self::SCENARIO_REGISTER_USER,
            ];
        }
        return $rules;
    }

    /**
     * @param $attribute string
     * @param $params array
     * @return boolean
     * */
    public function passwordCheck($attribute, $params)
    {
        if (self::checkPassword($this->$attribute)) {
            return true;
        }
        $this->addError($attribute,
            'Минимальная длина пароля - 8 символов, минимум 1 символ в верхнем регистре, минимум 1 цифра');
    }

    public static function checkPassword($password)
    {
        $hasUpperCase = preg_match('/\d/', $password);
        $hasNumber = preg_match('/[A-Z]/', $password);
        $minLength = mb_strlen($password) >= self::MIN_PASSWORD_LENGTH;
        if ($hasNumber && $hasUpperCase && $minLength) {
            return true;
        }
        return false;
    }

    public static function generatePassword()
    {
        $password = Yii::$app->security->generateRandomString(8);
        if (self::checkPassword($password)) {
            return $password;
        } else {
            return self::generatePassword();
        }
    }

    public function validateCurrentPassword()
    {
        if (!$this->validatePassword($this->currentPassword)) {
            $this->addError('currentPassword', 'Вы ввели не верный старый пароль.');
        }
    }

    /**
     * Проверить код подтверждения при обновлении профиля.
     */
    public function validateSettingsCode()
    {
        if (Yii::$app->session->get('settingsCode') !== $this->settingsCode) {
            $this->addError('settingsCode', 'Вы ввели не верный код подтверждения');
        }
    }

    /**
     * Задать код подтверждения при обновлении профиля.
     */
    public function setSettingsCode()
    {
        Yii::$app->session->set('settingsCode', self::generateCode());
    }

    /**
     * @return bool
     */
    public function changeProfile()
    {
        if (!$this->validate()) {
            return false;
        }

        $changing = new UserChanging([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'picture' => $this->picture,
            'email' => $this->email,
            'phone' => $this->phone,
            'skype' => $this->skype,
            'default_payment_system' => $this->default_payment_system,
            'confirmation_code' => UserChanging::generateCode(),
        ]);

        if (!empty($this->password1)) {
            $changing->password_hash = $this->setPassword($this->password1);
        } else {
            $changing->password_hash = $this->password_hash;
        }

        if ($changing->save(false)) {
            if ($this->role === User::ROLE_WEBMASTER) {
                return $this->sendSMSSettingsConfirmation($changing->confirmation_code);
            } else {
                return $this->sendEmailSettingsConfirmation($changing->confirmation_code);
            }
        }
        return false;
    }

    /**
     * @param $code
     * @return bool
     */
    private function sendSMSSettingsConfirmation($code)
    {
        return true;
    }

    /**
     * @param $code
     * @return bool
     */
    private function sendEmailSettingsConfirmation($code)
    {
        return true;
    }

    /**
     * @return bool
     */
    public function login()
    {
        $this->setLastVisit();
        return Yii::$app->user->login($this, 999999999);
    }

    private function setLastVisit()
    {
        $this->last_visit = date("Y-m-d H:i:s");
        $this->save(false);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'picture' => 'Фото',
            'email' => 'Email',
            'phone' => 'Телефон',
            'skype' => 'Скайп',
            'password_hash' => 'Пароль',
            'role' => 'Роль',
            'wmz' => 'WMZ',
            'wmr' => 'WMR',
            'yandex_money' => 'Яндекс.Деньги',
            'ip' => 'IP',
            'created_at' => 'Зарегистрирован',
            'last_visit' => 'Последний визит',
            'status' => 'Статус',
            'comment' => 'Комментарий',
            'password1' => 'Новый пароль',
            'password2' => 'Подтвердите пароль',
            'currentPassword' => 'Старый пароль',
            'displayRole' => 'Роль',
            'displayStatus' => 'Статус',
            'purchases_count' => 'Кол-во покупок',
            'goodsCount' => 'Кол-во товаров',
            'totalIncome' => 'Заработано',
            'availableIncome' => 'Выплата',
            'holdIncome' => 'Заморожено',
            'sales_count' => 'Продано',
            'payout_percent' => 'Партнерский процент',
            'payout_percent_type' => 'Тип партнерского процента',
            'settingsCode' => 'Проверочный код',
        ];
    }

    /**
     * Успешное подтверждение регистрации.
     */
    public function confirmEmail()
    {
        $this->email_confirmation = null;
        $this->save(false, ['email_confirmation']);

        /** @var Mailer $mailer */
        $mailer = Yii::$app->mailer;
        $mailer->userRegisterSuccess($this);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole(self::ROLE_DEFAULT);
            $auth->assign($role, $this->id);

            $this->sendConfirmationCode();
        } else {
            if (isset($changedAttributes['status'])) {
                Yii::$app->mailer->userChangedStatus($this);
            }
        }
    }

    /**
     * Отправить код активации.
     */
    private function sendConfirmationCode()
    {
        $this->email_confirmation = Yii::$app->security->generateRandomString();
        $this->save(false, ['email_confirmation']);

        /** @var Mailer $mailer */
        $mailer = Yii::$app->mailer;
        $mailer->userRegisterConfirmation($this, $this->email_confirmation);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($this->password1) {
            $this->setPassword($this->password1);
        }

        if ($insert) {
            $this->generateAuthKey();
            $this->generateAccessToken();
            if ($this->role !== self::ROLE_WEBMASTER) {
                $this->status = self::STATUS_ENABLED;
            }
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorite::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplates()
    {
        return $this->hasMany(Template::className(), ['user_id' => 'id'])
            ->andOnCondition(['template.is_deleted' => false]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return parent::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('Метод "findIdentityByAccessToken" не реализован.');
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() == $authKey;
    }

    /**
     * Generates password hash from password and sets it to the model
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        if (!$this->isNewRecord) {
            $this->isPasswordChanged = true;
        }
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates access token
     */
    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString(self::ACCESS_TOKEN_LENGTH);
    }

    public function getDisplayName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['user_id' => 'id']);
    }

    /**
     * @return mixed
     */
    public function getInvoicesSum()
    {
        return $this->getInvoices()->sum('sum');
    }

    /**
     * @return mixed
     */
    public function getTotalIncome()
    {
        $sql = "SELECT SUM(sum) - COALESCE((SELECT SUM(sum) FROM payout WHERE user_id = :user_id), 0)
                    FROM income WHERE user_id = :user_id";

        return (float)Yii::$app->db->createCommand($sql, [
            'user_id' => $this->id,
        ])->queryScalar();
    }

    /**
     * @return mixed
     */
    public function getHoldIncome()
    {
        $sql = "SELECT SUM(sum)
                    FROM income 
                    WHERE user_id = :user_id 
                        AND income.created_at > (NOW() - INTERVAL " . Income::HOLD_MINUTES . " MINUTE)";

        return (float)Yii::$app->db->createCommand($sql, [
            ':user_id' => $this->id,
        ])->queryScalar();
    }

    /**
     * @return mixed
     */
    public function getAvailableIncome()
    {
        $sql = "SELECT SUM(sum) - COALESCE((SELECT SUM(sum) FROM payout WHERE user_id = :user_id), 0)
                    FROM income 
                    WHERE user_id = :user_id 
                        AND income.created_at <= (NOW() - INTERVAL " . Income::HOLD_MINUTES . " MINUTE)";

        return (float)Yii::$app->db->createCommand($sql, [
            'user_id' => $this->id,
        ])->queryScalar();
    }

    /**
     * @return mixed|null
     */
    public function getDisplayRole()
    {
        return self::getRoleLabel($this->role);
    }

    /**
     * @return mixed|null
     */
    public function getDisplayStatus()
    {
        return self::getStatuses()[$this->status] ?? null;
    }

    /**
     * @return ActiveQuery
     */
    public function getIncomes()
    {
        return $this->hasMany(Income::className(), ['user_id' => 'id']);
    }

    /**
     * @return int
     * */
    public function getCustomerId()
    {
        return $this->id;
    }

    /**
     * @return string
     * */
    public function getCustomerEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     * */
    public function getCustomerPhone()
    {
        return $this->phone;
    }

    /**
     * @return integer
     * */
    public function getPayoutPercent()
    {
        return $this->payout_percent;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateNotices()
    {
        return $this->hasMany(TemplateNotice::class, ['user_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getUserRoute()
    {
        switch ($this->role) {
            case self::ROLE_WEBMASTER:
                $route = '/admin/webmaster/view';
                break;
            case self::ROLE_ADMIN:
                $route = '/admin/admin/view';
                break;
            default:
                $route = '/admin/user/view';
        }

        return [$route, 'id' => $this->id];
    }
}
