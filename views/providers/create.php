<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app', 'Add new Provider');/*
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Providers'), 'url' => ['index']];*/
$this->params['breadcrumbs'][] = $this->title;

$user_role =  Yii::$app->user->identity->user_role;
$provider_id =  Yii::$app->user->identity->provider_id;

?>
<div class="providers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_create', [
        'model' => $model, 'user' => $user
    ]) ?>

</div>
