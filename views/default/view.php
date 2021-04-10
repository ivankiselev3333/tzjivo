<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\components\JivoWidget;
$this->title = 'view';
$this->params['breadcrumbs'][] = $this->title;

if(!isset(Yii::$app->user->identity->email)){
    echo '<h1 style="color:red;">Авторизуйтесь чтобы увидить чат</h1>';
}
?>
<?= JivoWidget::widget(['user_id' => Yii::$app->user->identity->id, 'email'=>Yii::$app->user->identity->email]) ?>
<h1>Страница чата </h1>
