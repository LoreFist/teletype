<?php

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'queue',
    ],
    'modules' => [
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => [
                '@app/migrations',
            ],
        ],
    ],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
    ],
    'components' => [

    ],
    'on beforeAction' => function () {
        if (YII_DEBUG) {
            ini_set('memory_limit', '8G');
        }
    },
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
