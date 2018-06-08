<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);  $user_role =  Yii::$app->user->identity->user_role;  
if ( !in_array($user_role,[1,0])   ) {  exit();  }
 
$this->title = Yii::t('app', 'Providers');
$this->params['breadcrumbs'][] = $this->title; 
 		 

?> 

<div class="user-index">
<?php  if($user_role == 0){ ?>
     <div class="row top_btn_line">
		<div class="col-md-2 text-left">  <?= Html::a('Add Provider', ['create'], ['class' => 'btn btn-primary orange_button plus_icon']) ?> </div>
		<div class="col-md-8 text-center"> <h1><?= Html::encode($this->title)  ?>  </h1> </div>
	</div>	
	 
	 
	 
 <?php }
	   $provider_status = array( 'attribute' => 'status', 'filter'=> $GLOBALS["provider_status"] , 
	  	 'content' =>  function($data){   return  $data->getProvider_status_name( );  });	 
	     
 
   /*  ---------------------------- GET ALL PROVIDERS LIST -----------------------------------------  */ 
   if($user_role == 0){
       $rowOptions = function ($model, $key, $index, $grid) {
           return ['id' => $model['provider_id']];  };

   }elseif ($user_role == 1){
       $rowOptions = function ($model, $key, $index, $grid) {
           return ['id' => $model['provider_id'], 'style' => "cursor: pointer", 'onclick' => "  window.location.href = '" . Url::to(['providers/view']) . "?&id=". $model['provider_id'] ."' ;"];  };

   }

   echo GridView::widget([
	   
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
         'rowOptions' => $rowOptions,

       'columns' => [
           ['class' => 'yii\grid\SerialColumn'],

           //'provider_logo',
           [
               'attribute' => 'provider_logo',
               'format' => 'raw',
               'value' => function ($data) {
                   return Html::img(Yii::getAlias('@web').'/web/uploads/providers/'. $data['provider_logo'],
                       ['width' => '70px']);
               },
               'contentOptions' => ['class' => 'text-center'],
               'headerOptions' => ['class' => 'text-center']
           ],
           'provider_title',
           'provider_info',
           $provider_status,

           //['class' => 'yii\grid\ActionColumn', 'contentOptions' => ['width' => '80px;'] ],

       ]
    ]); ?>
</div>
