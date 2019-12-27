<?php

function dd($exp)
{
    var_dump($exp);
    die();
}

function vd($exp) {
    echo "<pre>";
    var_dump($exp);
    die;
}

function pr($exp) {
    echo "<pre>";
    print_r($exp);
    die;
}

function activateToken() {
    $allow = false;
    \Yii::$app->params['activateGetToken'] = 1;
    $paymentUrls = [
        '/payment/invoice-confirmation',
        '/payment/invoice-notification',
        '/payment/success',
        '/payment/failure',
    ];
    if ($token = \Yii::$app->request->get('getAccessToken')) {
        if ($token == \Yii::$app->params['getAccessToken']) {
            $allow = true;
        }
    } elseif (\Yii::$app->request->isAjax) {
        $allow = true;
    } else {
        foreach ($paymentUrls as $url) {
            if (strpos(\Yii::$app->request->url, $url) === 0) {
                $allow = true;
            }
        }
    }
    if (!$allow) {
        echo "<h1>Forbidden</h1>";die;
    }
}

function concat($string) {
    $newString = preg_replace('/\s+/', '_', $string);
    return $newString;
}