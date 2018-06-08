<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = Yii::t('app','Update').': ' . $model->product_title;
if($model->module == 'food_menu'){
    $this->params['breadcrumbs'][] = isset($_SESSION['breadcrumbs']) ? $_SESSION['breadcrumbs'] :['label' => Yii::t('app','Products : Food Menu'), 'url' => ['food_menu']];
}else{
    $this->params['breadcrumbs'][] = isset($_SESSION['breadcrumbs']) ? $_SESSION['breadcrumbs'] :['label' => Yii::t('app','Products: Additional Service'), 'url' => ['additional_service']];
}

//$this->params['breadcrumbs'][] = ['label' => $model->prod_id, 'url' => ['view', 'id' => $model->prod_id]];
$this->params['breadcrumbs'][] = Yii::t('app','Update');
?>
<div class="products-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
