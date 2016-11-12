<?php

use yii\db\Migration;

class m161112_083256_add_test_users extends Migration
{
    private $users = [
        'Иванов Иван Иванович',
        'Петро Петр Петрович',
        'Пупкин Василий Алибабаевич'
    ];

    public function safeUp()
    {
        foreach ($this->users as $user) {
            $model = new \app\models\User();
            $model->name = $user;
            $model->balance = 0;
            $model->datetime = date('Y-m-d H:i:s');
            $model->save();
        }
    }

    public function safeDown()
    {
        /*
         * Вариант 1 - в реальном проекте использовать нельзя, при откате миграций
         * удалит пользователей с совпадающими ФИО, тут пишу только потому что
         * данные тестовые
         */
//        foreach ($this->users as $user) {
//            $model = \app\models\User::find()->where(['name'=>$user])->one();
//            $model->delete();
//        }
        /**
         * Вариант 2 - просто ретурним true, пользователей не удалит, но не очень
         * то и хотелось, зато откат будет считаться успешным и данные не пострадают
         */
        return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
