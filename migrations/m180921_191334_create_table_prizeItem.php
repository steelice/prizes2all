<?php

use yii\db\Migration;

/**
 * Class m180921_191334_create_table_prizeItem
 */
class m180921_191334_create_table_prizeItem extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%prizeItem}}', [
            'id' => 'INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT \'ID\'',
            'createdAt' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT \'Дата добавления\'',
            'updatedAt' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT \'Дата изменения\'',
            'name' => 'VARCHAR(255) NOT NULL COMMENT \'Название\'',
            'taken' => 'TINYINT(4) NOT NULL DEFAULT \'0\' COMMENT \'Предмет взят\'',
            'PRIMARY KEY (`id`)',
            'INDEX `taken` (`taken`)'
        ], 'ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%prizeItem}}');
    }

}
