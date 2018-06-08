<?php

use kartik\select2\Select2;
use yii\helpers\Html;


$user_role =  Yii::$app->user->identity->user_role;  
$provider_id =  Yii::$app->user->identity->provider_id;
if (  $user_role  > 3  ) {  exit();  } 

$this->title = Yii::t('app','Modules');
$this->params['breadcrumbs'][] = $this->title;

//-----------------------------------------------------------------

$mod_status = ''; $sort_order = '';  if ( $_POST ) {   	// echo '<pre>' . var_dump( $key ). ' </pre>'; // die();

if ( array_key_exists('mod_status', $_POST )) {  $mod_status = $_POST["mod_status"]; }
if ( array_key_exists('sort_order', $_POST )) {  $sort_order = $_POST["sort_order"]; }
if ( array_key_exists('module_role', $_POST )) {  $module_role = $_POST["module_role"]; }

if( $mod_status != '' ) { 
	foreach( $mod_status as $key => $val ) {  
		$sql =  " UPDATE cl_".$provider_id."_modules SET  status = '". $val."' WHERE link = '". $key ."'  LIMIT 1   ";
	    $res = Yii::$app->db->createCommand( $sql )->execute();
}}

if( $sort_order != '' ) { 
	foreach( $sort_order as $key => $val ) {  
		$sql =  " UPDATE cl_".$provider_id."_modules SET  sort_order = '". $val."' WHERE link = '". $key ."'  LIMIT 1   ";
	    $res = Yii::$app->db->createCommand( $sql )->execute();
}}

if( $module_role != '' ) { 
	foreach( $module_role as $key  => $val  ) {  
		
		$users_roles = '';
		
		foreach( $val as $key2  => $val2  ) { $users_roles = $users_roles ."|". $val2;   }
		
		//echo '<br/>'. $key. " - "  . $users_roles;
		$sql =  " UPDATE cl_".$provider_id."_modules SET  module_role_id = '". $users_roles ."' WHERE link = '". $key ."'  LIMIT 1   ";
	    $res = Yii::$app->db->createCommand( $sql )->execute();
	    
}} // end - module_role

 }
 



function getUser_roles( )
{    
	$user_role =  $GLOBALS["user_role"];  
  
	unset( $user_role[1]);
  
    return  $user_role;
} 
 
 
?>
<div class="modules-index">
	
	<div class="row top_btn_line">
		<div class="col-md-2 text-left">  </div>
		<div class="col-md-8 text-center"> <h1><?= Html::encode($this->title); ?>  </h1>  </div>
	</div>	

<form action="<?= \yii\helpers\Url::to('index'); ?>" name="modules_form" method="post">
	
	<div class="row modules_list_header">
		<div class="col-md-3 text-left"> <b> <?=Yii::t('app','Name')?></b> </div>
		<div class="col-md-3 text-left"> <b> <?=Yii::t('app','Status')?></b> </div>
		<div class="col-md-5 text-left"> <b> <?=Yii::t('app','Role')?> </b> </div>
		<div class="col-md-1 text-right"> <b> <?=Yii::t('app','Sort')?> </b> </div>
	</div>		
				
<?php 
	// ----------------------------------------------------------------------------------- // 
    // ------------------------------  TOP LEVEL ITEMS 
    // ----------------------------------------------------------------------------------- //
	
	
	$sql =  "SELECT * FROM cl_".$provider_id."_modules WHERE sub_module = 'n'  ORDER BY sort_order ASC  ";
   $res = Yii::$app->db->createCommand( $sql )->queryAll();
   foreach ( $res as $row ) { 	   
	    
   ?>
   <div class="module_row"> 
   <div class="row modules_list">
		<div class="col-md-3 text-left"> <b><?= $row['module_name']; ?></b> <br/> <i> <?= $row['link']; ?> </i> </div>
		<div class="col-md-3 text-left">  
				<div class="btn-group" data-toggle="buttons">
	                <label class="btn btn-default <?php if( $row['status'] == 'y' ) { echo 'active';  } else { echo ''; } ; ?>">  
	                	<input type="radio" name="mod_status[<?= $row['link']; ?>]" <?php if( $row['status'] == 'y' ) { echo  ' selected="selected" ';  } ?> value="y" /> Enabled </label> 
	                <label class="btn btn-default <?php if( $row['status'] == 'n' ) { echo 'active';  } else { echo ''; } ; ?>">  
	                	<input type="radio" name="mod_status[<?= $row['link']; ?>]" <?php if( $row['status'] == 'n' ) { echo  ' selected="selected" ';  } ?> value="n" /> Disabled </label> 
                </div>
		</div>
	  	<div class="col-md-5 text-left">  
			<?php  // Multiple select without model
					echo Select2::widget([
					    'name' => 'module_role['. $row['link'] .']',
					    'value' => explode( "|", $row['module_role_id'] ),
					    'data' => getUser_roles( ),
					    'options' => ['multiple' => true, 'placeholder' => 'Select states ...']
					]);
				?>
		</div>
		<div class="col-md-1 text-right"> 
			<select class="form-control" name="sort_order[<?= $row['link']; ?>]">
			  <?php $num = 1;  while( $num <= 20 ) { ?>
			 	 <option value="<?= $num ?>" <?php if ( $row['sort_order'] == $num ) { echo ' selected="selected" '; }  ?> ><?= $num ?></option> 
			  <?php $num++; } ?>
			</select>
		</div>
	</div> 
	<?php 
	// ----------------------------------------------------------------------------------- // 
    // ------------------------------  SUB LEVEL ITEMS 
    // ----------------------------------------------------------------------------------- //
	/* 	$sql2 =  "SELECT * FROM cl_".$provider_id."_modules WHERE sub_module = 'y' AND parent_page = '". $row['link'] ."'  ORDER BY sort_order ASC  ";
		$res2 = Yii::$app->db->createCommand( $sql2 )->queryAll();
		foreach ( $res2 as $row2 ) {   ?> 
		 
	
		  <div class="row ">
			<div class="col-md-3 text-left"> <b><li> <?= $row2['module_name']; ?></li> </b> <br/> <i> <?= $row2['link']; ?> </i> <br/><br/>  </div>
			<div class="col-md-3 text-left">  
					<div class="btn-group" data-toggle="buttons">
		                <label class="btn btn-default <?php if( $row2['status'] == 'y' ) { echo 'active';  } else { echo ''; } ; ?>">  
		                	<input type="radio" name="mod_status[<?= $row2['link']; ?>]" <?php if( $row2['status'] == 'y' ) { echo  ' selected="selected" ';  } ?> value="y" /> Enabled </label> 
		                <label class="btn btn-default <?php if( $row2['status'] == 'n' ) { echo 'active';  } else { echo ''; } ; ?>">  
		                	<input type="radio" name="mod_status[<?= $row2['link']; ?>]" <?php if( $row2['status'] == 'n' ) { echo  ' selected="selected" ';  } ?> value="n" /> Disabled </label> 
	                </div>
			</div>
		  	<div class="col-md-5 text-left"> 
				<?php   
					// Multiple select without model
					echo Select2::widget([
					    'name' => 'module_role['. $row2['link'] .']',
					    'value' => explode( "|", $row2['module_role_id'] ),
					    'data' => getUser_roles( ),
					    'options' => ['multiple' => true, 'placeholder' => 'Select states ...']
					]);
				?>
			</div>
			<div class="col-md-1 text-right">  &nbsp; </div>
		</div> 	
   
		<?php } */ ?>   
		</div> 
    <?php } ?>
     
     <br/> <div class="row">
	    <div class="col-md-12 text-center">
	        <?= Html::submitButton(  Yii::t('app','Save Modules'), ['class' =>  'btn btn-primary']) ?>
	    </div>
    </div>
</form> 

</div>
