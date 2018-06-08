<?php

use yii\helpers\Html;


$provider_id =  Yii::$app->user->identity->provider_id;	
$user_role =  Yii::$app->user->identity->user_role;  
if ( $user_role == 0  ||   $model->provider_id != $provider_id   ) {  echo '<h1>'.Yii::t('app','Access is denied!').'</h1>';  die();  }

		
		 
$this->title = Yii::t('app', 'Edit: ' . $model->provider_title ) ;/*
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Providers'), 'url' => ['index']];*/
$this->params['breadcrumbs'][] = ['label' => $model->provider_id, 'url' => ['view', 'id' => $model->provider_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Edit Provider');
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model, 'admin_user' =>  $admin_user 
    ]) ?>

</div>
