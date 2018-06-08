<?php   
	   
use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\AppAsset;
use yii\helpers\Url;
use app\models\User; 
use kartik\select2\Select2;
 

$user_id =  Yii::$app->user->identity->user_id;	
$user_role =  Yii::$app->user->identity->user_role; 
$provider_id =  Yii::$app->user->identity->provider_id;  

$request = Yii::$app->request;


$users = new User(); // connect Users model




$edit = $request->get('edit');  

 if ( !$edit   ) {    $this->title = Yii::t('app','Users Groups');$this->params['breadcrumbs'][] = $this->title;
?>


<div class="groups-index">

    <div class="row top_btn_line">
		<div class="col-md-2 text-left"> <a class="btn btn-primary orange_button plus_icon fancybox" onclick="$('#window_group').show();" href="#window_add_group">Add Group</a> </div>
		<div class="col-md-8 text-center"> <h1> <?= $this->title ?> </h1> </div>
	</div>	
	
<?php $num = 1;  $sql =  " SELECT * from `cl_groups` WHERE provider_id = '".$provider_id."' ORDER BY group_id DESC   ";
   $res = Yii::$app->db->createCommand( $sql )->queryAll();
   foreach ( $res as $row ) {   ?>
   
   <div class="row">
	   		<div class="col-md-1 text-left"> #<?= $num; ?> </div>
	   		<div class="col-md-4 text-left"> <b> <?= $row['name']; ?> </b> </div>
	   		<div class="col-md-5 text-left"> <?php  
		   	   $sql2 =  " SELECT user_id from `cl_group_members`  WHERE group_id = '".$row['group_id']."'  GROUP BY user_id   ";
			   $res2 = Yii::$app->db->createCommand( $sql2 )->queryAll();
			   foreach ( $res2 as $row2 ) { 
				    $user_data = $users->find()->where(['user_id' => $row2['user_id']  ])->one();
				    ?> 
			   		<?= $user_data['first_name'] .' '. $user_data['last_name'] ; ?>, 
			   	<?php } ?> 
			</div>
	   		<div class="col-md-1 text-right"> 
		   		 <a href="<?=  \Yii::$app->request->BaseUrl; ?>/user/groups?&edit=<?= $row['group_id'] ?>" class="chat_delete_btn"> <i class="icon ion-document-text"></i> </a>
		    </div>
		    <div class="col-md-1 text-right"> 
		   		 <a href="<?=  \Yii::$app->request->BaseUrl; ?>/user/groups?&dg=<?= $row['group_id'] ?>" class="chat_delete_btn"> <i class="icon ion-trash-a"></i> </a>
		    </div>
	</div>	
   
   <?php $num++; }   ?>

</div>


<?php }
	
	// ----------------------------------------------------------------------------------- // 
    // ------------------------------  Edit Group Form
    // ----------------------------------------------------------------------------------- //  

if ( $edit ) {
	
   $members = array(); $output_list = array();
   
   $sql =  " SELECT * from `cl_groups` WHERE provider_id = '".$provider_id."' AND group_id = '".$edit."'  ";
   $res = Yii::$app->db->createCommand( $sql )->queryAll();
   foreach ( $res as $row ) {  
	      
		$sql2 =  "SELECT * FROM  cl_group_members as gm, cl_users as u  WHERE  u.login <> 'admin'  AND u.user_role >= 3  ";
		$res2 = Yii::$app->db->createCommand( $sql2 )->queryAll();
	    foreach ( $res2 as $row2 ) { 	  $output_list[ $row2['user_id'] ]  =  $row2['last_name'] .' '. $row2['first_name'];   }
	     
	}
	
	$sql2 =  " SELECT user_id from `cl_group_members`  WHERE group_id = '".$edit."'  GROUP BY user_id   ";
	$res2 = Yii::$app->db->createCommand( $sql2 )->queryAll();
	foreach ( $res2 as $row2 ) { 
			 $user_data = $users->find()->where(['user_id' => $row2['user_id']  ])->one();
			 $members[]  =  $user_data['user_id'];
	}
	 $this->title =  Yii::t('app','Edit : '.$row["name"]);

    $this->params['breadcrumbs'][] = ['label'=> Yii::t('app','Users Groups') , 'url' => ['groups']];
    $this->params['breadcrumbs'][] = $this->title;
?>
  
    <h3> Edit: "<?= $row["name"];?>" </h3>  <br/>
	  <form action="<?=  \Yii::$app->request->BaseUrl; ?>/user/groups" method="post">
      <div class="row">
	   		<div class="col-md-4 text-left"> Name </div> 
	   		<div class="col-md-8 text-left"> 
		    	<div class="form-group">
					<input type="text" class="form-control" name="group_name" value="<?= $row["name"];?>"> 
				</div>
		    </div> 
      </div> 
      <div class="row">
	   		<div class="col-md-4 text-left"> Users </div> 
	   		<div class="col-md-8 text-left"> 
		   		
		   	<?php  $user_model = new User;   
		  	    $output_list = $user_model->getRelations_list( $provider_id, 'all' ) ;
		   		
		    // Multiple select without model
			echo Select2::widget([
			    'name' => 'group_users',
			    'value' =>  $members ,  
			    'data' => $output_list,
			    'options' => ['multiple' => true, 'placeholder' => 'Select users ...']
			]);
		   		
	   		?> </div>
      </div> <br/>		
     <input  type="hidden" name="edit_group" value="<?= $row["group_id"];?>">               
     <button type="submit" class="btn btn-warning center-block text-center"> Edit Group</button>
	 </form>
	 
<?php  } ?>



<?php  // ----------------------------------------------------------------------------------- // 
    // ------------------------------  Add Group Form
    // ----------------------------------------------------------------------------------- //  
?>
 
  <div style="display:none" id="window_group">
      <div id="window_add_group">

    <h4> <?= Yii::t('app','Add New Group')?> </h4>
	  <form method="post">
      <div class="row">
	   		<div class="col-md-4 text-left"> Name </div> 
	   		<div class="col-md-8 text-left"> 
		    	<div class="form-group">
					<input type="text" class="form-control" name="new_group_name" value=""> 
				</div>
		    </div> 
      </div>  
                    
     <button type="submit" class="btn btn-warning center-block text-center"> <?= Yii::t('app','Create Group')?></button>
	 </form>
	                     
  </div></div>
  
<!-- Add Group Form  - END  -->
 
 
 

