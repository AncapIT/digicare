<?php


use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\AppAsset;
use yii\helpers\Url;

 // -------- check access level ---------
$provider_id =  Yii::$app->user->identity->provider_id;	
$user_role =  Yii::$app->user->identity->user_role;   
// --- end - check access level

$request = Yii::$app->request; $pid =  $request->get('pid'); if( !$pid ) { $pid = 1;  } 


$this->title = 'Orders - Service : New Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">
 
     <div class="row top_btn_line">
	<!--	<div class="col-md-2 text-left">  <?/*= Html::a(Yii::t('app','Add Order'), ['orders/create/?&pid=' . $pid ], ['class' => 'btn btn-primary orange_button plus_icon']) */?> </div>
	-->	<div class="col-md-8 text-center"> <h1><?= Html::encode($this->title)  ?>  </h1> </div>
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
	   
		$output_list = array(); 
		$sql =  "SELECT * FROM cl_users   WHERE  login <> 'admin'   AND user_role = 4   ";
	    $res = Yii::$app->db->createCommand( $sql )->queryAll();
	    foreach ( $res as $row ) { 	  $output_list[ $row['user_id'] ]  =  $row['first_name'] ." ". $row['last_name'];   }
			    
		return $output_list;  
	   }

    function getPatients_list() {

        $output_list = array();
        $sql =  "SELECT * FROM cl_users   WHERE  login <> 'admin'   AND user_role = 4   ";
        $res = Yii::$app->db->createCommand( $sql )->queryAll();
        foreach ( $res as $row ) { 	  $output_list[ $row['user_id'] ]  =  $row['first_name'] ." ". $row['last_name'];   }

        return $output_list;
    }

    $user_name = array( 'attribute' => 'user_id', 'filter'=>  getUsers_list() ,
	  	 'content' =>  function($data){   return  $data->getUser_name( $data['user_id'] );  });
    $patient_name = array( 'attribute' => 'patient_id', 'filter'=>  getPatients_list() ,
        'content' =>  function($data){   return  $data->getUser_name( $data['patient_id'] );  });



    $order_status = array( 'attribute' => 'order_status', 'filter'=> false ,
               'content' =>  function($data){   return  $data->getOrder_status_title( $data['order_status'] );  });



    ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        
         'rowOptions' => function ($model, $key, $index, $grid  ) {
	        $request = Yii::$app->request; $pid =  $request->get('pid'); if( !$pid ) { $pid = 1;  }  
		 	return ['id' => $model['order_id'], 'style' => "cursor: pointer", 'onclick' => 
		 	"  window.location.href = '" . Url::to(['orders/view']) . "?&id=". $model['order_id'] ."&pid=".$pid."' ;"];  },
		 	
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'order_id',
            'order_title',
            //'user_id',
            $patient_name,
            $user_name,
            //'product_type',
            //'selected_items',
            'create_date',
            $order_status,

            'price',
            //'order_status',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
