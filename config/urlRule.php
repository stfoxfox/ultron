<?php

return [
    '' => 'site/index',
    'admin' => 'admin/user/index',
    'admin/<controller>' => 'admin/<controller>/index',
    'user/<controller>' => 'user/<controller>/index',
    'confirm/<code:\w+>' => 'site/confirm',
    'forgot/<secret:\w+>' => 'site/forgot',
    'review/index' => 'review/index',
    'about' => 'page/view',
    'site/seller' => 'template/404',
    [
        'class' => 'app\components\TemplateUrlRule',
    ],
    'page/<alias:[\w-]+>' => 'page/view',
    '<action:(seller|login|register|logout|seller-reg|subscribe|forgot)>' => '/site/<action>',
    'template' => 'template/404',
    'template/<id:\d+>' => 'template/404',
    [
        'class' => \app\components\UrlRuleTemplateTypeCategory::class,
        'pattern' => 'templates/<type:[\w-]+>/<category:[\w-]+>',
        'route' => 'template/index',
        'defaults' => ['category' => 'all']
    ],
    'templates' => 'template/index',
    '<controller>' => '<controller>/index',
    '<controller>/<id:\d*>' => '<controller>/view',
];