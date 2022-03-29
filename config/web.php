<?php
Yii::setAlias('@logsfolder', 'logs');

$params = require_once(__DIR__ . '/params.php');
$db = require_once(__DIR__ . '/db.php');
//$db = require __DIR__ . '/db_test.php';
$session = require_once(__DIR__ . '/session.php');
$log = require_once(__DIR__ . '/logger.php');
$mailer = require_once(__DIR__ . '/mailer.php');
$cache = require_once(__DIR__ . '/cache.php');
$modules = require_once(__DIR__ . '/modules.php');


$config = [
    'id' => 'app',
    'language' => 'en',
    'timeZone' => 'Africa/Nairobi',
    'name' => 'App Name',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'request' => [
            'cookieValidationKey' => 'D47934BCCAO2TROSBDCP230YGNPS0DU2P34,FSGD9FWH23RW=R980RWFWO',
            'enableCsrfValidation' => true,
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/adminlte3/views'
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'app\common\models\User',
            'enableAutoLogin' => false
        ],
        'formatter' => [
            'class' => 'app\common\components\MyFormatter',
            'decimalSeparator' => '.',
            'thousandSeparator' => ',',
            'currencyCode' => 'KES',
            'defaultTimeZone' => 'Africa/Nairobi'
        ],
        'cache' => $cache,
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => $mailer,
        'log' => $log,
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller>/<action:(update|delete|view)>/<id:\d+>' => '<controller>/<action>',
                '<module>/<controller>/<action:(update|delete|view)>/<id:\d+>' => '<module>/<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
    'as access' => [
        'class' => 'app\common\components\MyAccessControl',
        'allowActions' => [
//            '*',
            'site/logout',
            'site/request-password-reset'
        ]
    ],
    'modules' => $modules,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
