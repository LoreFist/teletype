<?php

use app\models\Client;
use app\models\Dialog;
use yii\db\Migration;

class m250521_070727_dialogs extends Migration
{
    public const string FK_NAME_DIALOGS_CLIENT_ID = 'fk-dialogs-client_id';

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable(Dialog::tableName(), [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull()->unique(),
        ]);

        $this->addForeignKey(
            self::FK_NAME_DIALOGS_CLIENT_ID,
            Dialog::tableName(),
            'client_id',
            Client::tableName(),
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropForeignKey(self::FK_NAME_DIALOGS_CLIENT_ID, Dialog::tableName());
        $this->dropTable(Dialog::tableName());
    }
}
