<?php

use yii\db\Migration;

/**
 * Class m181115_081347_foreign_key_add
 */
class m181115_081347_foreign_key_add extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fx_projectuser_user', 'project_user', ['user_id'], 'user', ['id']);
        $this->addForeignKey('fx_projectuser_project', 'project_user', ['project_id'], 'project', ['project_id']);
        $this->addForeignKey('fx_project_user1', 'project', ['creator_by'], 'user', ['id']);
        $this->addForeignKey('fx_project_user2', 'project', ['updater_by'], 'user', ['id']);
        $this->addForeignKey('fx_task_user1', 'task', ['creator_by'], 'user', ['id']);
        $this->addForeignKey('fx_task_user2', 'task', ['updater_by'], 'user', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fx_projectuser_user', 'user');
        $this->dropForeignKey('fx_projectuser_project', 'project');
        $this->dropForeignKey('fx_project_user1', 'user');
        $this->dropForeignKey('fx_project_user2', 'user');
        $this->dropForeignKey('fx_task_user1', 'user');
        $this->dropForeignKey('fx_task_user2', 'user');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181115_081347_foreign_key_add cannot be reverted.\n";

        return false;
    }
    */
}
