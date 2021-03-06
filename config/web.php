<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'stoputei',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language'=> 'en',
    'defaultRoute' => '/site/welcome',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'mKI8SeSYA8n7hxh99eQ5hko8yTE_H7ZD',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            //'enableAutoLogin' => true,
            'authTimeout' => Yii::$app->params['authLoginTime']
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            //'useFileTransport' => false,
        ],
        'liqpay' => [
            'class' => 'app\components\LiqPay',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                ],

                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['liqpay'],
                    'logFile' => 'app\web\liqpay.txt',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'main' => 'site/index',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            ],
        ],
        //precompile sass
        'assetManager' => [
            'converter' => [
                'class' => 'yii\web\AssetConverter',
                'commands' => [
                    'scss' => ['css', 'sass {from} {to} '],
                    'sass' => ['css', 'sass {from} {to} '],
                ],
            ],
        ],
        //translations
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],

    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            // ... other configurations for the module ...
        ],
    ],

    'on beforeAction' => function ($event) {
        $afterRequest = new \app\components\AfterRequest();
        $afterRequest->setUserLocale();
    },
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
