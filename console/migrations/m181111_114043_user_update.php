<?php

use yii\db\Migration;

/**
 * Class m181111_114043_user_update
 */
class m181111_114043_user_update extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'user',
            'name',
            $this->string(255)->null()
            );
        
        $this->addColumn(
            'user',
            'avatar',
            $this->string(255)->null()
            );
        
        $this->addColumn(
            'user',
            'creator_id',
            $this->integer()->notNull()->defaultValue(0)
            );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'name');
        $this->dropColumn('user', 'avatar');
        $this->dropColumn('user', 'creator_id');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181111_114043_user_update cannot be reverted.\n";

        return false;
    }
    */
}
