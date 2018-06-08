<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */

$this->title = Yii::t('app','Update Module: ') . $model->menu_title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Modules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->menu_title, 'url' => ['view', 'id' => $model->mid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="menu-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
