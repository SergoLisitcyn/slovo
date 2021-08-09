<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'baseUrl' => '',
            'enableCsrfValidation'=>false,
         ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'blog' => '/blog/index',
                'news' => '/sale-news/index-news',
                'actions' => '/sale-news/index-sales',
                'reviews' => '/reviews/index',
                [
                    'pattern' => 'blog/<url:\S+>',
                    'route' => '/blog/view',
                    'defaults' => ['url' => '']
                ],
                [
                    'pattern' => 'sale-news/<url:\S+>',
                    'route' => '/sale-news/news-view',
                    'defaults' => ['url' => '']
                ],
                [
                    'pattern' => 'actions/<url:\S+>',
                    'route' => '/sale-news/sales-view',
                    'defaults' => ['url' => '']
                ],
                [
                    'pattern' => 'page/<slug:\S+>',
                    'route' => '/pages/show-page',
                    'defaults' => ['slug' => 'error']
                ],
            ],
        ],

    ],
    'params' => $params,
];
