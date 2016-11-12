<?php

namespace app\controllers;

use app\models\Log;
use app\models\UserTransaction;
use Yii;
use yii\web\Controller;

class RestController extends Controller
{
    public function actionProvOne()
    {
        $get = Yii::$app->request->get();
        $user = $get['a'];
        $amount = $get['b'];
        $md = $get['md5'];
        if ($md === md5($user . $amount . Yii::$app->params['salt1'])) {
            // если все ок, создаем транзакцию
            if (UserTransaction::create($user, $amount, 1))
                return '<answer>1</answer>';
        }else{
            // если данные некорректны или md5 не совпадает
            $log = new Log();
            $log->time = date('Y-m-d H:i:s');
            $log->pay_system = 1;
            $log->user_id = $user;
            $log->amount = $amount;
            $log->status = 0;
            $log->comment = 'Некорректные данные или md5 не совпадает';
            $log->save();
        }
        return '<answer>0</answer>';
    }

    public function actionProvTwo()
    {
        $get = Yii::$app->request->get();
        $user = $get['x'];
        $amount = $get['y'];
        $md = $get['md5'];
        if ($md === md5($user . $amount . Yii::$app->params['salt2'])) {
            // если все ок, создаем транзакцию
            if (UserTransaction::create($user, $amount, 2))
                return 'OK';
        } else {
            // если данные некорректны или md5 не совпадает
            $log = new Log();
            $log->time = date('Y-m-d H:i:s');
            $log->pay_system = 2;
            $log->user_id = $user;
            $log->amount = $amount;
            $log->status = 0;
            $log->comment = 'Некорректные данные или md5 не совпадает';
            $log->save();
        }
        return 'ERROR';
    }
}