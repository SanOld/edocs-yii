<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '5pxdjfEI9YEO3aBu89sC3MaRgFLyCScL',
//            'baseUrl' => '',
        ],
//        'cache' => [
//            'class' => 'yii\caching\FileCache',
//        ],
        'custom_db' => require(__DIR__ . '/custom_db.php'),
     
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'on afterLogin' => function($event)
              {
                  Yii::$app->user->identity->afterLogin($event);
              }
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
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
        'db' => require(__DIR__ . '/db.php'),
        
        'urlManager' => [
            'enablePrettyUrl' => true,
//            'showScriptName' => false,
//            'enableStrictParsing' => false,
            'rules' => [
              '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',              
            ],
        ],
        'permissionManager' => [
          'class' => 'app\components\PermissionManager',
          'permissions' => [
            'admin' => [
              'ac_show' => 1
              ,'cart' => 1
              ,'document_show' => 1
            ],
            'customer' => [
              'document_show' => 1
            ],
            'user' => [
              'default' => 1
            ],
            'default' => [
              'default' => 1
            ]
          ]
        ],
        'sphinx' => [     
          'class' => 'yii\sphinx\Connection',     
          'dsn' => 'mysql:host=127.0.0.1;port=9306;', // Обязательно укажите порт, который Вы задали в конфигурационном файле sphinx, секция searchd параметр listen
          'username' => '',
          'password' => '', ], 
    ],
    'params' => $params, 
          
];

if ( YII_ENV == 'dev' ) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
