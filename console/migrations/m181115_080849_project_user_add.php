<?php

use yii\db\Migration;

/**
 * Class m181115_080849_project_user_add
 */
class m181115_080849_project_user_add extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('project_user', [
            'project_user_id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'role' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('project_user');
        
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181115_080849_project_user_add cannot be reverted.\n";

        return false;
    }
    */
}
