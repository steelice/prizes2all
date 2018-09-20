<?php

use yii\db\Migration;

class m180920_083438_create_table_setting extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%setting}}', [
            'name' => $this->string(50)->notNull()->append('PRIMARY KEY')->comment('Ключ'),
            'title' => $this->string()->notNull()->comment('Заголовок'),
            'value' => $this->text()->comment('Значение'),
            'type' => 'ENUM(\'number\',\'string\',\'text\') NOT NULL DEFAULT \'string\' COMMENT \'Тип поля\'',
            'updatedAt' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT \'Последнее изменение\'',
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%setting}}');
    }
}
