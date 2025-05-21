<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => "pgsql:host={$_ENV['POSTGRES_HOST']};port={$_ENV['POSTGRES_PORT']};dbname={$_ENV['POSTGRES_DATABASE']}",
    'username' => $_ENV['POSTGRES_USER'],
    'password' => $_ENV['POSTGRES_PASSWORD'],
    'charset' => 'utf8',
    'emulatePrepare' => true,
    'enableSchemaCache' => true,
    'schemaMap' => [
        'pgsql' => [
            'class' => 'yii\db\pgsql\Schema',
            'defaultSchema' => $_ENV['POSTGRES_SCHEMA'],
            'columnSchemaClass' => [
                'class' => 'yii\db\pgsql\ColumnSchema',
                'deserializeArrayColumnToArrayExpression' => false,
            ],
        ],
    ],
    'on afterOpen' => function (yii\base\Event $event) {
        /** @var yii\db\Connection $sender */
        $sender = $event->sender;
        if ($sender->getDriverName() === 'pgsql') {
            $sender->pdo->exec("SET TIME ZONE 'Europe/Moscow'");
        }
    },
];
