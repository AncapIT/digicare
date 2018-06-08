<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app','Provider').': '. $model->provider_title;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Providers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$provider_id =  Yii::$app->user->identity->provider_id;	
$user_role =  Yii::$app->user->identity->user_role;  
if (  ( $model->provider_id != $provider_id )  ) {  echo '<h1>'.Yii::t('app','Access is denied!').'</h1>';  die();  }
		
		
?>
<div class="user-view">
    
      <div class="row top_btn_line">
		<div class="col-md-4 text-left"> 
				<?php   if( $user_role == 1  ) {  echo Html::a(Yii::t('app', 'Edit Provider'), [ 'update', 'id' => $model->provider_id ], ['class' => 'btn btn-primary']) ; } ?>
		        <?php /*  echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->provider_id], [
		            'class' => 'btn btn-danger',
		            'data' => [
		                'confirm' => Yii::t('app', 'Are you sure you want to delete the Provider?'),
		                'method' => 'post',
		            ],
		        ]) */ ?>
		</div>
		<div class="col-md-10 text-center"> <h1><?= Html::encode($this->title)  ?>  </h1> </div>
	</div>	

    <?php 
 	    
	    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'provider_id', 
            'provider_title', 
            'provider_info',
            'provider_status_name',
            'currency',
            'currency_place',
            'stripe_currency',
            'ui_rows',
            'email_alerts_orders',
            'email_alerts_messages'
        ],
    ])     ?>

    <?=$model->getCreatedUpdated(); ?>

</div>
