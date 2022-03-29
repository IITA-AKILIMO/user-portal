<?php
$expireAfterSeconds = 18000;
return [
    'class' => 'yii\web\DbSession',
    // Set the following if you want to use DB component other than
    // default 'db'.
    // 'db' => 'mydb',
    // To override default session table, set the following
    'sessionTable' => 'app_session',
    /*'cookieParams' => [
        'httponly' => true,
        'lifetime' => $expireAfterSeconds,
    ],*/
    'timeout' => $expireAfterSeconds,
    'useCookies' => true,
    'writeCallback' => function ($session) {
        return [
            'user_id' => Yii::$app->user->id != null ? Yii::$app->user->id : 0,
            'ip' => Yii::$app->request->getUserIP(),
            'username' => Yii::$app->user->identity != null ? Yii::$app->user->identity->name : 'guest'
        ];
    },
];
