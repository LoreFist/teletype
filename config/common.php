<?php

return [
    'modules' => [

    ],
    'components' => [
        'db' => require __DIR__ . '/db.php',
        'log' => require __DIR__ . '/log.php',
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => $_ENV['KEYDB_HOST'],
            'port' => $_ENV['KEYDB_PORT'],
            'database' => $_ENV['KEYDB_DB'],
            'retries' => 10,
            'retryInterval' => 200,
        ],
        'cache_array' => [
            'class' => 'yii\caching\ArrayCache',
            'serializer' => false,
        ],
        'cache' => [
            'class' => 'yii\redis\Cache',
            'keyPrefix' => 'cache.',
        ],
        'mutex' => [
            'class' => 'yii\redis\Mutex',
            'keyPrefix' => 'mutex.',
        ],
        'queue' => [
            'class' => 'yii\queue\redis\Queue',
            'channel' => 'queue',
            'as log' => 'yii\queue\LogBehavior',
        ],
    ],
    'container' => [
        'definitions' => [
            'yii\behaviors\TimestampBehavior' => [
                'value' => new yii\db\Expression("NOW()"),
            ],
        ],
    ],
    'params' => require __DIR__ . '/params.php',
];
