<?php

use yii\db\Migration;

class m180920_071127_create_table_social_account extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%social_account}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'provider' => $this->string()->notNull(),
            'client_id' => $this->string()->notNull(),
            'data' => $this->text(),
            'code' => $this->string(),
            'created_at' => $this->integer(),
            'email' => $this->string(),
            'username' => $this->string(),
        ], $tableOptions);

        $this->createIndex('account_unique', '{{%social_account}}', ['provider', 'client_id'], true);
        $this->createIndex('account_unique_code', '{{%social_account}}', 'code', true);
        $this->addForeignKey('fk_user_account', '{{%social_account}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%social_account}}');
    }
}
