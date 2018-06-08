<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Messages */
$view = isset($_GET['view'])? $_GET['view'] : null;
if(isset($_GET['chat_group'])){
    $patient = \app\models\User::findOne($_GET['chat_group']);
    $this->title = $patient->first_name. ' '.$patient->last_name;
}

$this->params['breadcrumbs'][] = isset($_SESSION['breadcrumbs']) ? $_SESSION['breadcrumbs'] : ['label' => Yii::t('app',$view? 'New Messages' : 'Messages History'), 'url' => ['index','view'=>$view]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="messages-create">

    <h1>Chat Messages: <?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'view' => $view
    ]) ?>

</div>
