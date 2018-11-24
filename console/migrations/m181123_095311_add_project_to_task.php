<?php

use yii\db\Migration;

/**
 * Создать миграцию добавляющую поле project_id (integer, not null ) в task, после поля estimation,
 * также сделать удаленный ключ между project_id и id в project. Для определения после какого поля 
 * вставить в миграциях есть метод after().
 */
class m181123_095311_add_project_to_task extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    	$this->addColumn('task', 'project_id', $this->integer()->notNull()->after('estimation'));
    	$this->addForeignKey('fx_task_project', 'task', ['project_id'], 'project', ['project_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    	$this->dropForeignKey('fx_task_project', 'project');
    	$this->dropColumn('project_id', 'task');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181123_095311_add_project_to_task cannot be reverted.\n";

        return false;
    }
    */
}
