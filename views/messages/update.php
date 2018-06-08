<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Messages */

$this->title = Yii::t('app','Update Messages').': ' . $model->id;
$this->params['breadcrumbs'][] = isset($_SESSION['breadcrumbs']) ? $_SESSION['breadcrumbs'] : ['label' => Yii::t('app','Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app','Update');
?>
<div class="messages-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
