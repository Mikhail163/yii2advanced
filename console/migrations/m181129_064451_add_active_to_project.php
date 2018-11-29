<?php

use yii\db\Migration;

/**
 * Создать миграцию для добавления boolean поля active в project после description
 */
class m181129_064451_add_active_to_project extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    	$this->addColumn('project', 'active', $this->boolean()->defaultValue(false)->after('description'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    	$this->dropColumn('project', 'active');
    	
    	return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181129_064451_add_active_to_project cannot be reverted.\n";

        return false;
    }
    */
}
