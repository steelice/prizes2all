<?php

use yii\db\Migration;

class m180920_083532_update_table_setting extends Migration
{
    public function safeUp()
    {
        $this->insert('setting', [
            'name' => 'money',
            'title' => 'Запас денег',
            'type' => 'number',
            'value' => 1000
        ]);

        $this->insert('setting', [
            'name' => 'bonus_rate',
            'title' => 'Коэффициент обмена денег на бонусные баллы',
            'type' => 'number',
            'value' => 10
        ]);

        $this->insert('setting', [
            'name' => 'money_min',
            'title' => 'Минимальный денежный приз',
            'type' => 'number',
            'value' => 10
        ]);
        $this->insert('setting', [
            'name' => 'money_max',
            'title' => 'Максимальный денежный приз',
            'type' => 'number',
            'value' => 20
        ]);
        $this->insert('setting', [
            'name' => 'bonus_min',
            'title' => 'Минимальный бонусный приз',
            'type' => 'number',
            'value' => 100
        ]);
        $this->insert('setting', [
            'name' => 'bonus_max',
            'title' => 'Максимальный бонусный приз',
            'type' => 'number',
            'value' => 200
        ]);
    }

    public function safeDown()
    {
        $this->delete('setting', [
            'name' => ['money', 'money_min', 'money_max', 'bonus_min', 'bonus_max', 'bonus_rate']
        ]);
    }
}
