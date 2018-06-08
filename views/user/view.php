<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app','User').': '. $model->first_name . ' ' . $model->last_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title; 

$provider_id =  Yii::$app->user->identity->provider_id;	
$user_role =  Yii::$app->user->identity->user_role;  
if ( $user_role > 0 && ( $model->provider_id != $provider_id )  ) {  echo '<h1>Access is denied!</h1>';  die();  }


$user_model = new User;  
		
?>
<div class="user-view">
    
      <div class="row top_btn_line">
		<div class="col-md-4 text-left"> 
				<?= Html::a(Yii::t('app', 'Edit User'), ['update', 'id' => $model->id ], ['class' => 'btn btn-primary']) ?>
		        <?php  Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
		            'class' => 'btn btn-danger',
		            'data' => [
		                'confirm' => Yii::t('app', 'Are you sure you want to forget the user?'),
		                'method' => 'post',
		            ],
		        ]) ?>
		</div>
		<div class="col-md-8 text-center"> <h1><?= Html::encode($this->title); ?>  </h1> </div> 
	</div>	

    <?php   // get binded users  
	    $user_model = new User;   
		$relation_users =  $user_model->getBinded_users( $model->user_id ); 
	    
	    $user_groups = '';
	    $sql=  "SELECT * FROM  cl_group_members as gm, cl_groups as g  WHERE g.group_id = gm.group_id AND  gm.user_id = '". $model->user_id ."' AND gm.group_type = 'group'" ;
		$res = Yii::$app->db->createCommand( $sql )->queryAll();
	    foreach ( $res as $row ) { 	  $user_groups   .=  $row['name'].  '; ' ;   }

	    $attributes =  [
            [
                'attribute'=>'photo',
                'value'=> \Yii::$app->request->BaseUrl. '/web/uploads/users/'.  $model->photo,
                'format' => [ 'image',[ 'width'=> '320']],
            ],
            'login',
            'first_name',
            'last_name',
            'phone',
            //'provider_id',
            [
                'label' => Yii::t('app','Provider'),
                'value' => $model->getProvider_name( $model->provider_id  ),
            ],
            [
                'label' => Yii::t('app','Binded User'),
                'value' => $relation_users,
            ],
            [
                'label' => Yii::t('app','Binded Groups'),
                'value' => $user_groups,
            ],
            'email:email',
            'user_role_name',
            'user_status_name',
            'login_bankid',
            'login_username',
            'food',

        ];
	    if($model->user_role == 4 ){ $attributes[] = ['attribute'=>'consent','value'=> $model->getConsentInfo()];}


	    echo DetailView::widget([
        'model' => $model,
        'attributes' => $attributes
    ]) ?>

    <?=$model->getCreatedUpdated(); ?>
</div>
