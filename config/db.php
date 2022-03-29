<?php

$db = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=db_name',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];

$dbLocal = [];
if (file_exists(__DIR__ . '/db_test.php')) {
    $dbLocal = require_once(__DIR__ . '/db_test.php');
}

return yii\helpers\ArrayHelper::merge(
    $db,
    $dbLocal
);
