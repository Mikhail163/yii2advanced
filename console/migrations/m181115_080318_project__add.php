<?php

use yii\db\Migration;

/**
 * Class m181115_080318_project__add
 */
class m181115_080318_project__add extends Migration
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
         created_by - integer, not null
         updated_by - integer, null
         created_at - integer, not null
         updated_at - integer, null
         */
        $this->createTable('project', [
            'project_id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
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
        $this->dropTable('project');
        
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181115_080318_project__add cannot be reverted.\n";

        return false;
    }
    */
}
