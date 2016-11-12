<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_transaction".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $amount
 * @property string $time
 *
 * @property User $user
 */
class UserTransaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['amount'], 'number'],
            [['time'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'amount' => 'Amount',
            'time' => 'Time',
        ];
    }

    public static function create($user, $amount, $paySystem)
    {
        $model = new UserTransaction();
        $model->user_id = $user;
        $model->amount = $amount;
        $model->time = date('Y-m-d H:i:s');
        // создаем запись в лог
        $log = new Log();
        $log->pay_system = $paySystem;
        $log->user_id = $user;
        $log->amount = $amount;
        $log->time = $model->time;
        // если транзакция успешно записана
        if ($model->save()) {
            $us = User::findOne($user);
            $us->datetime = $model->time;
            $us->balance = $us->balance + $amount;
            $us->save();
            $log->status = 1;
            $log->comment = 'success';
            $log->save();
            return 1;
        } else {
            $log->status = 0;
            $log->comment = json_encode($model->errors);
            $log->save();
            return 0;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
