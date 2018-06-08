<?php

use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

// -------- check access level ---------
$provider_id =  Yii::$app->user->identity->provider_id;	
$user_role =  Yii::$app->user->identity->user_role;   
// --- end - check access level

?>

<div class="documents-form">
	  
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'doc_title')->textInput(['maxlength' => true]) ?>
    
    <?php
			
	$data =  array();  
	$sql =  "SELECT * FROM  cl_users  WHERE user_role = 4  ";
	if( $user_role > 0 ) {   $sql .= " AND provider_id  = " . $provider_id ; }
	
    $res = Yii::$app->db->createCommand( $sql )->queryAll();
    foreach ( $res as $row ) { 	 $data[ $row["user_id"] ] =  $row["last_name"] ." ". $row["first_name"];  }
		
	  // SELECT LIST - Providers
	  echo $form->field( $model, 'user_id' )->widget(Select2::classname(), [
	    'data' => $data,
	    'language' => 'en',
	    'options' => ['placeholder' => 'Select ...'],
	    'pluginOptions' => [
	        'allowClear' => true
			],
	  ]); // END - SELECT LIST 
	?>
 
    <?= $form->field($model, 'doc_header')->textInput(['maxlength' => true]) ?> 
    
    <?php   // SELECT LIST -  TYPE 
	  echo $form->field( $model, 'doc_type' )->widget(Select2::classname(), [
	    'data' =>  $GLOBALS["document_types"],
	    'language' => 'en',
	    'options' => ['placeholder' => 'Select ...'],
	    'pluginOptions' => [
	        'allowClear' => true
			],
	  ]); // END - SELECT LIST 
	  ?>
	  
	  <?php //  $form->field($model, 'doc_date')->textInput(['maxlength' => true]) ?> 
	  
    <?php  // DATE AND TIME PICKER
      echo '<label class="control-label">'.Yii::t('app','Document Date').'</label>';
	echo DateTimePicker::widget([
	    'name' => 'Documents[doc_date]', 
	    'value' => $model->doc_date ,
	    'pluginOptions' => [
	        'autoclose'=>true,
	        'format' => 'yyyy-mm-dd HH:ii:ss', 'startDate' => date('Y-m-d H:i:s')
	    ]
	]);    ?> <br/>

    <?= $form->field($model,'published')->checkbox(['checked'=>$model->isNewRecord ? 'checked':''])
    ?>
    <?= $form->field($model, 'doc_content')->textarea(['rows' => 6]) ?>
    
      <?php   // SELECT LIST -  category_desc
	  echo $form->field( $model, 'category_desc' )->widget(Select2::classname(), [
	    'data' =>  [ 'y' => 'Yes', 'n' => 'No' ],
	    'language' => 'en',
	    'options' => ['placeholder' => 'Select ...'],
	    'pluginOptions' => [
	        'allowClear' => true
			],
	  ]); // END - SELECT LIST 
	  ?>
	  
 
    <?= $form->field($model, 'pdf_link')->textInput(['maxlength' => true]) ?>
    


    <div class="row" style="position: relative;display: inline-block;border: 1px solid #555;padding: 10px;">
        <button type="button" class="close" onclick="removeImage()" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php  // Display an initial preview of files with caption

        echo Html::img(Yii::$app->request->baseUrl.'/web/uploads/news/' . $model->doc_image,['style'=>'max-width:250px;max-height:250px;display: block;margin-top: 19px;','id'=>'user-photo-img']);
        echo $form->field($model,'doc_image')->fileInput(['accept' => 'image/*']);
        ?>
        <script type="text/javascript">
            function removeImage() {
                $('#user-photo-img').attr('src','<?= Yii::$app->request->baseUrl.'/uploads/users/' ;?>');
                $("input[name='old_image']").val('');
                $("input[name='Documents[doc_image]']").val(null);
            };
        </script>
    </div>

		<input type="hidden" name="old_image" value="<?= $model->doc_image ?>">
	 <br/>
	 

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app','Create' ): Yii::t('app','Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
