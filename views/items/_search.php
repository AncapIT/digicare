<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Items */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="items-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'item_id') ?>

    <?= $form->field($model, 'doc_id') ?>

    <?= $form->field($model, 'doc_type') ?>

    <?= $form->field($model, 'item_date') ?>

    <?= $form->field($model, 'item_title') ?>

    <?php // echo $form->field($model, 'item_header') ?>

    <?php // echo $form->field($model, 'item_content') ?>

    <?php // echo $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'pdf_link') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app','Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
