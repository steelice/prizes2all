<?php

use yii\db\Migration;

/**
 * Class m180921_193425_alter_table_user_add_bonuses_field
 */
class m180921_193425_alter_table_user_add_bonuses_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'bonuses', 'INT(11) NOT NULL DEFAULT \'0\' COMMENT \'Бонусы\'');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'bonuses');
    }
}
