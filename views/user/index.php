<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\AppAsset;
use yii\helpers\Url;
use app\models\User;

AppAsset::register($this);  $user_role =  Yii::$app->user->identity->user_role;  
if (  $user_role  > 3  ) {  exit();  } 
 
$this->title = Yii::t('app', 'Users List');
$this->params['breadcrumbs'][] = $this->title;
 
$user_model = new User;  

?> 

<div class="user-index">

     <div class="row top_btn_line">
		<div class="col-md-2 text-left">  <?= Html::a('Add User', ['create'], ['class' => 'btn btn-primary orange_button plus_icon']) ?> </div>
		<div class="col-md-8 text-center"> <h1><?= Html::encode($this->title)  ?>  </h1> </div>
	</div>	
	 
	 
	 
 <?php   /*  ---------------------------- GET PROVIDERS LIST -----------------------------------------  */ 
	    
	  function getProviders_list() { 
			
		   $providers =  array(); 
		   $sql =  "SELECT * FROM  cl_providers WHERE status <> 1   ";
		   $res = Yii::$app->db->createCommand( $sql )->queryAll();
		   foreach ( $res as $row ) { 	 $providers[ $row['provider_id'] ] =    $row['provider_title'] ;   }
		    
		   return $providers; 
		 } // END - getProviders_list
		 
	 
	  if( $user_role == 0 ) { 	 // Provider list for Admin 
  
	  $providers_list = array( 'attribute' => 'provider_id', 'filter'=> getProviders_list(), 
	  	 'content' =>  function($data){   return  $data->getProvider_name( $data['provider_id']  );  });
	  
	  } else {   $providers_list = array( 'attribute' => 'provider_id', 'filter'=> [], 
	  	 'content' =>  function($data){   return  $data->getProvider_name( $data['provider_id']  );  });
	  }
	  	 
	  $user_status = array( 'attribute' => 'login_allowed', 'filter'=> $GLOBALS["user_status"] ,
	  	 'content' =>  function($data){   return  $data->getUser_Status_name();  });	 
	   
	  $user_role = array( 'attribute' => 'user_role', 'filter'=> $GLOBALS["user_role"] , 
	  	 'content' =>  function($data){   return  $data->getUser_role_name( );  });	
 
 
	  // get binded users 
	     
	    $relations = array( 'attribute' => 'relations.parent_id', 'filter'=> [] , 
	  	'content' =>  function($data){    $user_model = new User;   
		  	return  $user_model->getBinded_users( $data['user_id']  );  	
		  	});
	 
	 
 
   /*  ---------------------------- GET ALL USERS LIST -----------------------------------------  */

   echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $grid) {
		 	return ['id' => $model['id'], 'style' => "cursor: pointer", 'onclick' => 
		 	"  window.location.href = '" . Url::to(['user/view']) . "?&id=". $model['id'] ."' ;"];  },

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'login', 
            'first_name',
            'last_name',  
            'address', 
            'phone',
             $relations,
            //'relations.parent_id',
			 $user_status,
            'login_bankid',
            'login_username',
             //$providers_list,
             $user_role,
              
            //['class' => 'yii\grid\ActionColumn', 'contentOptions' => ['width' => '80px;'] ],
            
        ],
    ]); ?>
    
    
     
</div>
