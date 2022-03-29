<?php
return [
    'traceLevel' => YII_DEBUG ? 3 : 0,
    'flushInterval' => 1,
    'targets' => [

        'file' => [
            'class' => 'yii\log\FileTarget',
            'categories' => ['yii\web\HttpException:404'],
            'levels' => ['error', 'warning', 'info'],
            'logFile' => '@logsfolder/application.log',
            'prefix' => function ($message) {
                return Yii::$app->id;
            }
        ],
        [
            'class' => 'yii\log\FileTarget',
            'logFile' => '@logsfolder/http-request.log',
            'categories' => ['yii\httpclient\*'],
        ],
    ],
];