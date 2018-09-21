<?php

use yii\db\Migration;

/**
 * Class m180921_191954_create_table_prizeUser
 */
class m180921_191954_create_table_prizeUser extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%prizeUser}}', [
            'id' => 'INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT \'ID\'',
            'createdAt' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT \'Дата добавления\'',
            'userId' => 'INT(11) NOT NULL',
            'typeId' => 'INT(10) UNSIGNED NOT NULL',
            'itemId' => 'INT(10) UNSIGNED NULL DEFAULT NULL COMMENT \'Предмет (если есть)\'',
            'value' => 'INT(10) UNSIGNED NULL DEFAULT NULL COMMENT \'Сумма (для бонусов или денег)\'',
            'status' => 'ENUM(\'new\',\'accepted\',\'sent\',\'error\',\'cancelled\') NULL DEFAULT \'new\' COMMENT \'Статус\'',
            'userNotes' => 'TEXT NULL COMMENT \'Примечание пользователя\'',
            'PRIMARY KEY (`id`)',
            'INDEX `FK_prizeUser_user` (`userId`)',
            'INDEX `FK_prizeUser_prizeType` (`typeId`)',
            'INDEX `FK_prizeUser_prizeItem` (`itemId`)',
            'CONSTRAINT `FK_prizeUser_prizeItem` FOREIGN KEY (`itemId`) REFERENCES `prizeItem` (`id`) ON UPDATE CASCADE',
            'CONSTRAINT `FK_prizeUser_prizeType` FOREIGN KEY (`typeId`) REFERENCES `prizeType` (`id`) ON UPDATE CASCADE ON DELETE CASCADE',
            'CONSTRAINT `FK_prizeUser_user` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON UPDATE CASCADE ON DELETE CASCADE',
        ], 'ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%prizeUser}}');
    }
}
