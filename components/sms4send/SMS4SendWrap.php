<?php

namespace app\components\sms4send;

/**
 * Class SMS4SendWrap
 * @package frontend\ext\sms4send
 */
class SMS4SendWrap extends \yii\base\Component
{

    /** @var string */
    public $login = '';

    /** @var string */
    public $password = '';

    /** @var string */
    public $senderName = '';

    /** @var \SMSClient */
    protected $client = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        require_once('SMSClient.php');
        $this->client = new \SMSClient($this->login, $this->password);
        if ($this->client) {
            $sessionId = $this->client->getSessionID();
        }
    }

    /**
     * @param $phones
     * @param $message
     * @return array
     */
    public function send($phones, $message)
    {
        if ($this->client) {
            try {
                return $this->client->sendBulk($this->senderName, $phones, $message);
            } catch (\Exception $e) {
                echo $e->getMessage(),
                $e->getTraceAsString();
                // todo: add error log...
            }
        }
        return false;
    }

    /**
     * Метод возвращает баланс счета.
     * @return float
     */
    public function getbalance()
    {
        if ($this->client) {
            try {
                return $this->client->getBalance();
            } catch (\Exception $e) {
                // todo: add error log...
            }
        }
        return false;
    }
}
