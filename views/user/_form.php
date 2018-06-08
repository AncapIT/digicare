<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;  
use kartik\select2\Select2;
use kartik\file\FileInput;  
use app\models\User;
 
 
 // -------- check access level ---------
$provider_id =  Yii::$app->user->identity->provider_id;	
$user_role =  Yii::$app->user->identity->user_role;   
if ( !$model->isNewRecord &&  $user_role > 0 && ( $model->provider_id != $provider_id )  ) {  echo '<h1>'.Yii::t('app','Access is denied!').'</h1>'; die();  }
// --- end - check access level

$user_model = new User;  



// Multiple select Relative Users
			$relations_list = array(); 
			$sql=  "SELECT * FROM  cl_group_members as gm, cl_users as u  WHERE   u.user_id =  gm.user_id   AND gm.user_id = '". $model->user_id ."'   ";  
			if( $provider_id > 0 ) {   $sql .= " AND u.provider_id  = " . $provider_id ; }
			
		    $res = Yii::$app->db->createCommand( $sql )->queryAll();
		    foreach ( $res as $row ) { 	  
			    if( $row['parent_id'] > 0 ) { $relations_list[]  =  $row['parent_id'];  } }
		    
		    
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
	 

    <div style="display: <?= $model->isNewRecord ? 'block' : 'none' ?>;">
        <?= $form->field($model, 'user_role')->dropDownList( $GLOBALS["user_role"] , ['prompt'=>'Select']) ?>
    </div>
    
	
	<?= $form->field($model, 'first_name')->textInput() ?>
	
	<?= $form->field($model, 'last_name')->textInput() ?>
	 
	<input type="hidden"  name="User[provider_id]" value="<?php if ( $model->isNewRecord ) { echo $provider_id; } else { echo  $model->provider_id; }  ?>">


    <div id="binded_users_area">
        <b> <?= Yii::t('app','Patient Connection')?> </b>
        <?php  echo Select2::widget([
            'name' => 'relations_list',
            'value' => $relations_list,
            'language' => 'en',
            'data' => $model->getRelations_list( $provider_id, $model->user_role ),
            'options' => ['multiple' => true, 'placeholder' => 'Select Connections Users ...']
        ]);
        ?> <br/>
    </div>
	
 
	<div id="binded_groups_area">
		<b> <?= Yii::t('app','Groups')?> </b>
		<?php 
			
		$group_list = array(); 
		$sql=  "SELECT * FROM  cl_groups  WHERE  provider_id  = " . $provider_id ;  
		$res = Yii::$app->db->createCommand( $sql )->queryAll();
	    foreach ( $res as $row ) { 	  $group_list[  $row['group_id'] ]  =  $row['name'];   }
	    
	    $user_groups  = array();
	    $sql=  "SELECT * FROM  cl_group_members  WHERE  user_id = '". $model->user_id ."' AND group_type = 'group'  " ;  
		$res = Yii::$app->db->createCommand( $sql )->queryAll();
	    foreach ( $res as $row ) { 	  $user_groups[]  =  $row['group_id'] ;   }
		
	     	echo Select2::widget([
			    'name' => 'group_id',
			    'value' => $user_groups, 
			    'language' => 'en',
			    'data' => $group_list,
			    'options' => ['multiple' => true, 'placeholder' => 'Select Groups...']
			]);
		?> <br/>
	</div> 
	
 	
    <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>
    
    <?php // echo $form->field($model, 'password')->textInput(['maxlength' => true]) ?>
    
   <!-- <div class="form-group">
		<label class="control-label" for="user-password"><?/*= Yii::t('app','New Password')*/?></label>
		<input type="text" id="user-password" class="form-control" name="User[new_password]" value="" maxlength="150" aria-invalid="false">
		<div class="help-block"></div>
	</div>-->

    <?= $form->field($model, 'new_password')->textInput(); ?>

    <div class="form-inline">
        <span style="display: inline-block; margin-right: 10px;" > <?php  echo $form->field($model, 'login_allowed')->checkbox(['style'=>'dislay:inline-block']);?></span>

        <span style="display: inline-block; margin-right: 10px;" ><?php  echo $form->field($model, 'login_bankid')->checkbox(['style'=>'dislay:inline-block']);?></span>
            <span style="display: inline-block; margin-right: 10px;" ><?php  echo $form->field($model, 'login_username')->checkbox(['style'=>'dislay:inline-block']);?></span>
    </div>

    <?= $form->field($model, 'phone')->textInput() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'address')->textInput() ?>

    <?= $form->field($model, 'food')->checkbox() ?>
    <?= $form->field($model, 'consent')->checkbox() ?>
	 <div class="row" style="position: relative;display: inline-block;border: 1px solid #555;padding: 10px;">
         <button type="button" class="close" onclick="removeImage()" aria-label="Close">
             <span aria-hidden="true">&times;</span>
         </button>
	 <?php  // Display an initial preview of files with caption

     echo Html::img(Yii::$app->request->baseUrl.'/web/uploads/users/' . $model->photo,['style'=>'max-width:250px;max-height:250px;display: block;margin-top: 19px;','id'=>'user-photo-img']);
     echo $form->field($model,'photo')->fileInput(['accept' => 'image/*']);
    ?>
         <script type="text/javascript">
             function removeImage() {
                 $('#user-photo-img').attr('src','<?= Yii::$app->request->baseUrl.'/web/uploads/users/def_img.png' ;?>');
                 $("input[name='old_image']").val('def_img.png');
                 $("input[name='User[photo]']").val(null);
             };
         </script>
    </div>
	 <input type="hidden" name="old_image" value="<?= $model->photo ?>">
	 <br/>
	 
	 
	 
	 
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save changes') : Yii::t('app', 'Save changes'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
