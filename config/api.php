<?php

return [
    'id' => 'basic-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
    ],
    'layout' => false,
    'controllerNamespace' => 'app\modules\api\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'app\models\User',
            'enableSession' => false,
            'loginUrl' => null,
        ],
        'request' => [
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'enableCsrfCookie' => false,
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
        ],
        'errorHandler' => [
            'errorAction' => null,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'ruleConfig' => ['class' => 'yii\rest\UrlRule'],
            'rules' => require __DIR__ . '/api_rules.php',
        ],
    ],
    'container' => [
        'definitions' => [
            'yii\web\JsonResponseFormatter' => [
                'prettyPrint' => YII_DEBUG,
                'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
            ],
        ],
    ],
];
