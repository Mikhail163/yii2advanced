<?php

use yii\db\Migration;

/**
 * Class m181115_075336_user_updater_id_add
 */
class m181115_075336_user_updater_id_add extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'user',
            'updater_id',
            $this->integer()->notNull()->defaultValue(0)
            );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'updater_id');
        
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181115_075336_user_updater_id_add cannot be reverted.\n";

        return false;
    }
    */
}
