<?php

use yii\db\Migration;

/**
 * Class m181115_080153_task_add
 */
class m181115_080153_task_add extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /*
         id - integer, primaryKey
         title - varchar(255), not null
         description - text, not null
         estimation - integer, not null, новое поле
         executor_id - integer, null, новое поле
         started_at - integer, null, новое поле
         completed_at - integer, null, новое поле
         created_by - integer, not null
         updated_by - integer, null
         created_at - integer, not null
         updated_at - integer, null
         */
        $this->createTable('task', [
            'task_id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->string(255)->notNull(),
            'estimation' => $this->integer()->notNull(),
            'executor_id' => $this->integer()->null(),
            'started_at' => $this->integer()->null(),
            'completed_at' => $this->integer()->null(),
            'creator_by' => $this->integer()->notNull(),
            'updater_by' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('task');
        
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181115_080153_task_add cannot be reverted.\n";

        return false;
    }
    */
}
