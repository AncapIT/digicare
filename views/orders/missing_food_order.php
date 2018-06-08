<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\AppAsset;
use yii\helpers\Url;
use app\models\User;

?> 

<div class="user-index">

	 
	 <div class="row hidden">
         <div class="col-md-3">
             <?= DateTimePicker::widget([
                 'name' => 'date_from',
                 'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                 'value' => Yii::$app->request->get('date_from'),
                 'pluginOptions' => [
                     'autoclose'=>true,
                     'format' => 'yyyy-mm-dd HH:ii',
                 ]
             ]) ?>
         </div>
         <div class="col-md-3">
             <?= DateTimePicker::widget([
                 'name' => 'date_to',
                 'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                 'value' => Yii::$app->request->get('date_to'),
                 'pluginOptions' => [
                     'autoclose'=>true,
                     'format' => 'yyyy-mm-dd HH:ii',
                 ]
             ]) ?>
         </div>
     </div>
	 
 <?   /*  ---------------------------- GET PROVIDERS LIST -----------------------------------------  */ 
	    
	  function getProviders_list() { 
			
		   $providers =  array(); 
		   $sql =  "SELECT * FROM  cl_providers WHERE status <> 1   ";
		   $res = Yii::$app->db->createCommand( $sql )->queryAll();
		   foreach ( $res as $row ) { 	 $providers[ $row['provider_id'] ] =    $row['provider_title'] ;   }
		    
		   return $providers; 
		 } // END - getProviders_list

	  	 
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
             $user_role,
              
            //['class' => 'yii\grid\ActionColumn', 'contentOptions' => ['width' => '80px;'] ],
            
        ],
    ]); ?>
    
    
     
</div>
