<?php

use app\models\Client;
use yii\db\Migration;

class m250521_070718_clients extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable(Client::tableName(), [
            'id' => $this->primaryKey(),
            'external_client_id' => $this->string(36)->notNull()->unique(),
            'phone' => $this->string(12)->notNull(),
        ]);

        $this->createIndex('idx-clients-phone', Client::tableName(), 'phone');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable(Client::tableName());
    }
}
