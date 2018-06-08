<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\AppAsset;
use yii\helpers\Url;

 // -------- check access level ---------
$provider_id =  Yii::$app->user->identity->provider_id;	
$user_role =  Yii::$app->user->identity->user_role;   
// --- end - check access level

$request = Yii::$app->request; $pid =  $request->get('pid');  
 
if ( $user_role > 0 ) { $pid = $provider_id ;  }
if(isset($_GET['Documents']['doc_type']) && $_GET['Documents']['doc_type'] == 'about_patient'){
    $this->title = Yii::t('app','Documents : About Patient');
}elseif(isset($_GET['Documents']['doc_type']) && $_GET['Documents']['doc_type'] == 'implementation'){
    $this->title = Yii::t('app','Documents : Implementation');
}elseif(isset($_GET['Documents']['doc_type']) && $_GET['Documents']['doc_type'] == 'diary'){
    $this->title = Yii::t('app','Documents : Diary');
}elseif(isset($_GET['Documents']['doc_type']) && $_GET['Documents']['doc_type'] == 'billboard'){
    $this->title = Yii::t('app','Documents : Billboard');
}elseif(isset($_GET['Documents']['doc_type']) && $_GET['Documents']['doc_type'] == 'calendar'){
    $this->title = Yii::t('app','Documents : Calendar');
}elseif(isset($_GET['Documents']['doc_type']) && $_GET['Documents']['doc_type'] == 'newsletter'){
    $this->title = Yii::t('app','Documents : Newsletter');
}
else {
    $this->title = Yii::t('app','Documents List');
}

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documents-index">
  
     <div class="row top_btn_line">
		<div class="col-md-2 text-left">  <?= Html::a(Yii::t('app','Add Doc'), ['documents/create/?&pid=' . $pid ], ['class' => 'btn btn-primary orange_button plus_icon']) ?> </div>
		<div class="col-md-8 text-center"> <h1><?= Html::encode($this->title)  ?>  </h1> </div>
		<div class="col-md-2 text-right">
			
			<?php if ( $user_role == 0 ) { ?> 
			<select class="provider_select form-control">
				   <?php  
				   $sql =  "SELECT * FROM  cl_providers WHERE status <> 1   ";
				   $res = Yii::$app->db->createCommand( $sql )->queryAll();
				   foreach ( $res as $row ) { 	?> 
				    	<option value="<?=  $row['provider_id'] ?>"  <?php if( $row['provider_id'] == $pid ) { ?> selected="selected" <?php } ?>>
						<?=  $row['provider_title'] ?></option>
				   <?php } ?>
			</select>
			<?php } ?>
		</div>
	</div>	
	
	<?php  
	/*  ---------------------------- GET USERS LIST -----------------------------------------  */ 
	    
    function getUsers_list() { 
				
				$provider_id =  Yii::$app->user->identity->provider_id;	
				$user_role =  Yii::$app->user->identity->user_role; 
	
			   $output =  array(); 
			   $sql =  "SELECT * FROM  cl_users WHERE login <> 'admin'  AND user_role = '4'  ";
			   if( $user_role > 0 ) {   $sql .= " AND provider_id  = " . $provider_id ; }
			   $res = Yii::$app->db->createCommand( $sql )->queryAll();
			   foreach ( $res as $row ) { 	 $output[ $row['user_id'] ] = $row['first_name']  ." ".  $row['last_name'] ;   }
			    
			   return $output; 
	 } // END - getUsers_list 
		 
	  $users_list = array( 'attribute' => 'user_id', 'filter'=> getUsers_list() , 
	  	 'content' =>  function($data){   return  $data->getUser_name( $data['user_id']  );  });	 
		
		 
	  $type_title = array( 'attribute' => 'doc_type', 'filter'=> $GLOBALS["document_types"] , 
	  	 'content' =>  function($data){   return  $data->getDoc_type_title( $data['doc_type'] );  });	 
	?>
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        
        'rowOptions' => function ($model, $key, $index, $grid  ) {
	        $request = Yii::$app->request; $pid =  $request->get('pid'); if( !$pid ) { $pid = 1;  } 
		 	return ['id' => $model['doc_id'], 'style' => "cursor: pointer", 'onclick' => 
		 	"  window.location.href = '" . Url::to(['documents/view']) . "?&id=". $model['doc_id'] ."&pid=".$pid."' ;"];  },
		 	
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'doc_id',
            'doc_title',
             $users_list,
            'doc_header',
            $type_title,
            //'doc_type',
            // 'doc_date',
            // 'doc_content:ntext',
            // 'doc_options',
            // 'doc_image',
            // 'pdf_link',
			//['class' => 'yii\grid\ActionColumn', 'contentOptions' => ['width' => '80px;'] ],
        ],
    ]); ?>
</div>
