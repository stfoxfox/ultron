<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'app\components\Bootstrap'],
    'language' => 'ru-RU',
    'name' => 'ULTRON - HTML шаблоны и MODX сборки готовых сайтов от лендинга до интернет-магазина.',
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'defaultRoute' => 'user/index',
        ],
        'redactor' => [
            'class' => 'yii\redactor\RedactorModule',
            'uploadDir' => '@webroot/uploads',
            'uploadUrl' => '@web/uploads',
            'imageAllowExtensions' => ['jpg', 'jpeg', 'png']
        ]
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'oIPeiOuzosNY-boEk9hp8sRheqPijSU0',
            'baseUrl' => '',
        ],
        'sms' => [
            'class' => 'app\components\sms4send\SMS4SendWrap',
            'login' => 'ultron',
            'password' => '9QWHxoer',
            'senderName' => 'Ultron.pro',
        ],
        'cache' => [
            'class' => 'yii\caching\DummyCache',
        ],
        'user' => [
            'class' => \app\components\User::class,
            'loginUrl' => ['/site/login'],
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'app\components\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
              'class' => 'Swift_SmtpTransport',
              'host' => 'smtp.yandex.ru',
              'username' => 'noreply@ultron.pro',
              'password' => '%eg440vg3',
              'port' => 465,
              'encryption' => 'ssl',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'cart' => [
            'class' => 'yz\shoppingcart\ShoppingCart',
            'cartId' => 'my_application_cart',
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'normalizer' => [
                'class' => 'yii\web\UrlNormalizer',
                'action' => \yii\web\UrlNormalizer::ACTION_REDIRECT_PERMANENT
            ],
            'rules' => require "urlRule.php",
        ],
        'formatter' => [
//            'dateFormat' => 'dd.MM.yyyy',
//            'decimalSeparator' => ',',
//            'thousandSeparator' => ' ',
            'sizeFormatBase' => 1000,
            'currencyCode' => 'RUB',
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
//            'defaultRoles' => [
//                'user'
//            ],
            'itemFile' => '@app/rbac/data/items.php',
            'assignmentFile' => '@app/rbac/data/assignments.php',
            'ruleFile' => '@app/rbac/data/rules.php',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,   // do not publish the bundle
                    'js' => [
                        '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
                    ]
                ],
            ],
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'vk' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => '',
                    'clientSecret' => '',
                ],
            ],
        ],
        'sphinx' => [
            'class' => 'yii\sphinx\Connection',
            'dsn' => 'mysql:host=127.0.0.1;port=9306;',
            'username' => YII_ENV != "dev" ? 'root' : 'ultron',
            'password' => YII_ENV != "dev" ? '' : 'n5%kSC3d',
        ],
        'reCaptcha' => [
            'class' => 'himiklab\yii2\recaptcha\ReCaptchaConfig',
            'siteKeyV3' => '6LeWbKIUAAAAAEFkxKrbKsN0V2g-HDKIcjpK4xNb',
            'secretV3' => '6LeWbKIUAAAAAK8fuohTbxpWrVb_hdxUoTFmGbN_',
        ],
    ],

    // чтоб отключить проверку токена уберите или закоментируйте начиная отсюда
//    'on beforeRequest' => function () { activateToken(); },

    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

//    $config['bootstrap'][] = 'gii';
//    $config['modules']['gii'] = [
//        'class' => 'yii\gii\Module',
//        'allowedIPs' => ['*'],
//    ];
}

return $config;
