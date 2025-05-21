<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => "pgsql:host=postgres;port=5432;dbname=teletype",
    'username' => 'teletype',
    'password' => 'teletype',
    'charset' => 'utf8',
    'emulatePrepare' => true,
    'enableSchemaCache' => true,
    'attributes' => [
        PDO::ATTR_PERSISTENT => true,
    ],
    'on afterOpen' => function (yii\base\Event $event) {
        /** @var yii\db\Connection $sender */
        $sender = $event->sender;
        if ($sender->getDriverName() === 'pgsql') {
            $sender->pdo->exec("SET TIME ZONE 'Europe/Moscow'");
        }
    },
];
