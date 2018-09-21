<?php

use yii\db\Migration;

class m180920_134350_create_table_prizeType extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%prizeType}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(20)->notNull()->comment('Внутреннее имя'),
            'title' => $this->string()->notNull()->comment('Тип'),
            'description' => $this->text()->notNull()->comment('Описание приза'),
            'chance' => $this->integer()->unsigned()->notNull()->defaultValue('100')->comment('Шанс выпадения'),
        ], $tableOptions);

        $this->createIndex('name', '{{%prizeType}}', 'name', true);

        $this->insert('prizeType', [
            'name' => \app\models\PrizeType::MONEY_INDEX,
            'title' => 'Деньги',
            'description' => 'Денежный приз переводится вам на счёт! Укажите номер вашей карты! Либо, вы можете сконвертировать их в бонусы',
        ]);

        $this->insert('prizeType', [
            'name' => \app\models\PrizeType::ITEM_INDEX,
            'title' => 'Подарок',
            'description' => 'Подарок мы отправим вам по почте! Укажите ваш адрес! Вы можете отказаться от подарка, если хотите',
        ]);

        $this->insert('prizeType', [
            'name' => \app\models\PrizeType::BONUS_INDEX,
            'title' => 'Бонусные баллы',
            'description' => 'Бонусные баллы начисляются на ваш бонусный счёт!',
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%prizeType}}');
    }
}
