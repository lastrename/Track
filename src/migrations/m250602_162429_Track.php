<?php

use yii\db\Migration;

class m250602_162429_Track extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%track}}', [
            'id' => $this->primaryKey(),
            'track_number' => $this->string()->notNull()->unique(),
            'status' => $this->string()->notNull()->defaultValue('new'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%track}}');
    }
}
