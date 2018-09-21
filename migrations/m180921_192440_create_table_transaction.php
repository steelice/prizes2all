<?php

use yii\db\Migration;

/**
 * Class m180921_192440_create_table_transaction
 */
class m180921_192440_create_table_transaction extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transaction}}', [
            'id' => 'INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT \'ID\'',
            'createdAt' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT \'Дата проведения\'',
            'userId' => 'INT(11) NOT NULL COMMENT \'Пользователь\'',
            'money' => 'DOUBLE NOT NULL DEFAULT \'0\' COMMENT \'Сумма\'',
            'prizeId' => 'INT(10) UNSIGNED NOT NULL DEFAULT \'0\'',
            'PRIMARY KEY (`id`)',
            'INDEX `FK__user` (`userId`)',
            'INDEX `FK__prizeUser` (`prizeId`)',
            'CONSTRAINT `FK__prizeUser` FOREIGN KEY (`prizeId`) REFERENCES `prizeUser` (`id`) ON UPDATE CASCADE ON DELETE CASCADE',
            'CONSTRAINT `FK__user` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON UPDATE CASCADE ON DELETE CASCADE',
        ], 'ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%transaction}}');
    }
}
