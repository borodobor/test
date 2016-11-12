<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin();
echo $form->field($model, 'name')->textInput()->label('Имя');
echo Html::submitButton('Найти', ['class' => 'btn btn-primary']);
ActiveForm::end();
$transactions = $model->userTransactions;
if ($model->name) {
    if ($transactions) {
        echo '<table class="table table-bordered table-striped"><tr><th>#</th><th>Имя</th><th>Сумма</th><th>Время</th></tr>';
        foreach ($transactions as $transaction) {
            echo '<tr><td>' . $transaction['id'] . '</td><td>' . $model->name . '</td><td>' . $transaction['amount'] . '</td><td>' . $transaction['time'] . '</td></tr>';
        }
        echo '</table>';
    } else {
        echo 'Транзакций у пользователя ' . $model->name . ' не найдено';
    }
} elseif($nouser ==false) {
    echo 'Пользователь не найден';
}


?>
<!--<table>-->
<!--    <thead>-->
<!--    <th>#</th><th>Имя</th><th>Сумма</th><th>Время</th>-->
<!--    </thead>-->
<!--    <tbody>-->
<!--    --><? // foreach ($transactions as $transaction): ?>
<!--        <tr>-->
<!--            <td>$transaction['id']</td>-->
<!--            <td>$model->name</td>-->
<!--            <td>$transaction['amount']</td>-->
<!--            <td>$transaction['time']</td>-->
<!--        </tr>-->
<!--    --><? // endforeach;?><!-->
<!--    </tbody>-->
<!--</table>-->
