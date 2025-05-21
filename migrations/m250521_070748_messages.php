<?php

use app\models\Dialog;
use app\models\Message;
use yii\db\Migration;

class m250521_070748_messages extends Migration
{
    public const string FK_NAME_MESSAGES_DIALOG_ID = 'fk-messages-dialog_id';

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable(Message::tableName(), [
            'id' => $this->primaryKey(),
            'dialog_id' => $this->integer()->notNull(),
            'external_message_id' => $this->string(36)->notNull()->unique(),
            'message_text' => $this->text()->notNull(),
            'send_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            self::FK_NAME_MESSAGES_DIALOG_ID,
            Message::tableName(),
            'dialog_id',
            Dialog::tableName(),
            'id',
            'CASCADE'
        );

        $this->createIndex('idx-messages-dialog_id', Message::tableName(), 'dialog_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropForeignKey(self::FK_NAME_MESSAGES_DIALOG_ID, Message::tableName());
        $this->dropTable(Message::tableName());
    }
}
