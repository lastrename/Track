<?php

use yii\db\Migration;

class m250602_184930_ModelLog extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%model_log}}', [
            'id' => $this->primaryKey(),
            'model_name' => $this->string()->notNull(),
            'model_id' => $this->integer()->notNull(),
            'attribute' => $this->string()->notNull(),
            'old_value' => $this->text(),
            'new_value' => $this->text(),
            'changed_at' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%model_log}}');
    }
}
