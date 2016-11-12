<?php

use yii\db\Migration;

class m161110_184436_create_tables extends Migration
{
    public function safeUp()
    {
        // таблица пользователей
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'balance' => $this->decimal(10, 2),
            'datetime' => $this->dateTime()
        ]);
        $this->createIndex('user_id', 'user', 'id');
        $this->createIndex('user_name', 'user', 'name');

        // таблица транзакций
        $this->createTable('user_transaction', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'amount' => $this->decimal(10, 2),
            'time' => $this->dateTime()
        ]);
        $this->createIndex('user_id', 'user_transaction', 'user_id');
        $this->addForeignKey('transaction_user_id', 'user_transaction', 'user_id', 'user', 'id');

        // таблица с логами
        $this->createTable('log', [
            'id' => $this->primaryKey(),
            'time' => $this->dateTime(),
            'pay_system' => $this->smallInteger(1),
            'user_id' => $this->integer(),
            'amount' => $this->string(),
            'status' => $this->smallInteger(1),
            'comment' => $this->text()
        ]);
        $this->createIndex('paysys', 'log', 'pay_system');
        $this->createIndex('user_id', 'log', 'user_id');
        $this->addForeignKey('log_user_id', 'log', 'user_id', 'user', 'id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('log_user_id', 'log');
        $this->dropTable('log');
        $this->dropForeignKey('transaction_user_id', 'user_transaction');
        $this->dropTable('user_transaction');
        $this->dropTable('user');
    }
}
