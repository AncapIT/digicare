<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

  
    <?php // $form->field($model, 'username') ?>
 
    <?= $form->field($model, 'm_name') ?>

    <?php  echo $form->field($model, 'city_id') ?>

    <?php   echo $form->field($model, 'role') ?>

    <?php // echo $form->field($model, 'password_hash') ?>

    <?php   echo $form->field($model, 'phone') ?>

    <?php  echo $form->field($model, 'email') ?>

    <?php   echo $form->field($model, 'login_allowed') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
