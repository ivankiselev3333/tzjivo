<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\users_integrations_jivosite_api */
/* @var $form ActiveForm */
?>
<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

        <h3>EMAIL: <?= $user->email ?></h3>

    <?php ActiveForm::end(); ?><?php $form = \yii\widgets\ActiveForm::begin([
        'id' => 'js-form',
        'action' => '/user/save',
        'method'=>'post',
        'enableAjaxValidation' => false,


    ]); ?>
    <?= $form->field($model, 'js')->textInput(); ?>
    <?= Html::submitButton("Submit", ['class' => "btn btn-default"]); ?>
    <?php $form->end(); ?>

</div>

<?php
$this->registerJs('$(document).ready(function() {

     $(\'#js-form\').on(\'beforeSubmit\', function() {
         // Получаем объект формы
         var $jsform = $(this);
         // отправляем данные на сервер
         $.ajax({
             // Метод отправки данных (тип запроса)
             type : $jsform.attr(\'method\'),
             // URL для отправки запроса
             url : $jsform.attr(\'action\'),
             // Данные формы
             data : $jsform.serializeArray()
         }).done(function(data) {
             if (data.error == null) {
                 // Если ответ сервера успешно получен
                // $("#output").text(data.data.text)
             } else {
                 // Если при обработке данных на сервере произошла ошибка
               //  $("#output").text(data.error)
             }
         }).fail(function() {
             // Если произошла ошибка при отправке запроса
             //$("#output").text("error3");
         })
         // Запрещаем прямую отправку данных из формы
         return false;
     })
 })
 ');