<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Modules */

$this->title = Yii::t('app','Update Modules').': ' . $model->module_id;
$this->params['breadcrumbs'][] = ['label' => 'Modules', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->module_id, 'url' => ['view', 'id' => $model->module_id]];
$this->params['breadcrumbs'][] = Yii::t('app','Update');
?>
<div class="modules-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
