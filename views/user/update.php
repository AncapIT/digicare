<?php

use yii\helpers\Html;

// -------- check access level ---------
$provider_id =  Yii::$app->user->identity->provider_id;	
$user_role =  Yii::$app->user->identity->user_role;  
if ( $user_role > 0 && ( $model->provider_id != $provider_id )  ) {  echo '<h1>'.Yii::t('app','Access is denied!').'</h1>'; die();  }
// --- end - check access level

$this->title = Yii::t('app', 'Edit: ' .  $model->first_name . ' ' . $model->last_name );

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Edit User');
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
