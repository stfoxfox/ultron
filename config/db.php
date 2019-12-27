<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => YII_ENV != "dev" ? 'mysql:host=localhost;dbname=admin_default' : 'mysql:host=127.0.0.1;dbname=ultron',
    'username' => YII_ENV != "dev" ? 'root' : 'stfox',
    'password' => YII_ENV != "dev" ? '' : 'ei7veeChu4bo',
    'charset' => 'utf8',
];
