<?php
use yii\console\controllers\MigrateController;

Yii::setAlias('@logsfolder', 'logs');
$params = require __DIR__ . '/params.php';
//$db = require __DIR__ . '/db.php';
$cache = require __DIR__ . '/cache.php';
$log = require_once(__DIR__ . '/logger.php');
$db = require __DIR__ . '/db_test.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => $cache,
        'log' => $log,
        'db' => $db,
    ],
    'params' => $params,
    'controllerMap' => [
        'migrate' => [
            'class' => MigrateController::class,
            'migrationPath' => [
                '@app/migrations/tables',
                '@yii/rbac/migrations', // Just in case you forgot to run it on console (see next note)
            ],
        ],
        'migrate-view' => [
            'class' => MigrateController::class,
            'migrationTable' => 'migration_view',
            'migrationPath' => [
                '@app/migrations/views',
            ],
        ],
        'migrate-sp' => [
            'class' => MigrateController::class,
            'migrationTable' => 'migration_functions',
            'migrationPath' => [
                '@app/migrations/sp',
            ],
        ]
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
