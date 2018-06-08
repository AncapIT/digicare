<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$user_role =  Yii::$app->user->identity->user_role;
if (  $user_role != 0 ) {  echo '<h1>'.Yii::t('app','Access is denied!').'</h1>';  die();  }
 
 ?>

<div class="providers-form">

    <?php $form = ActiveForm::begin(); ?>
	 
	 
    <?= $form->field($model, 'provider_title')->textInput() ?>
	
	<?= $form->field($model, 'provider_info')->textInput() ?>  
     
    <?php if ( $user_role == 0 || 1 == 1  ) { ?> 
	
	<?php  echo $form->field($model, 'status')->dropDownList( $GLOBALS["provider_status"] , ['prompt'=>'Select']);?> 
	
	<?php  echo $form->field($model, 'stripe_currency')->textInput() ?>

	
	<b>Currency</b> 
	<?php  
		echo Select2::widget([
			    'name' => 'currency',
			    'value' =>  [ $model->currency ],  
			    'data' => [ '€' => '€', '$' => '$', 'kr' => 'kr'],
			    'options' => ['multiple' => false, 'placeholder' => Yii::t('app','Select Currency...')]
			]);
	?>
	 
	<?php 	echo Select2::widget([
			    'name' => 'currency_place',
			    'value' => [ $model->currency_place ],  
			    'data' => [ 'after' => 'after', 'before' => 'before'],
			    'options' => ['multiple' => false, 'placeholder' => Yii::t('app','Currency place...')]
			]);
	?>

        <?php  echo $form->field($model, 'email_alerts_messages')->textInput() ?>
        <?php  echo $form->field($model, 'email_alerts_orders')->textInput() ?>
	
	<hr/>
	<h3> Admin user </h3>
	

  	<?php echo $form->field($user,'first_name')->textInput(); ?>
        <?php echo $form->field($user,'last_name')->textInput(); ?>
        <?php echo $form->field($user,'email')->textInput(); ?>
        <?php echo $form->field($user,'login')->textInput(); ?>
        <?php echo $form->field($user,'password')->textInput(); ?>
        <?php echo $form->field($user,'user_role')->hiddenInput()->label(false); ?>
        <?php echo $form->field($user,'login_allowed')->hiddenInput()->label(false); ?>
	
	 <?php } ?>

    <hr/>
    <h3> <?= Yii::t('app','Providers images')?> </h3>

    <div class="row" style="position: relative;display: inline-block;border: 1px solid #555;padding: 10px;">
        <button type="button" class="close" onclick="removeImage()" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php  // Display an initial preview of files with caption

        echo Html::img(Yii::$app->request->baseUrl.'/web/uploads/news/' . $model->provider_logo,['style'=>'max-width:250px;max-height:250px;display: block;margin-top: 19px;','id'=>'user-photo-img']);
        echo $form->field($model,'provider_logo')->fileInput(['accept' => 'image/*']);
        ?>
        <script type="text/javascript">
            function removeImage() {
                $('#user-photo-img').attr('src','<?= Yii::$app->request->baseUrl.'/uploads/users/' ;?>');
                $("input[name='old_image']").val('');
            };
        </script>
    </div>
    <input type="hidden" name="old_image" value="<?= $model->provider_logo ?>">
    <hr/>


    <div class="row" style="position: relative;display: inline-block;border: 1px solid #555;padding: 10px;">
        <button type="button" class="close" onclick="removeImage2()" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php  // Display an initial preview of files with caption

        echo Html::img(Yii::$app->request->baseUrl.'/web/uploads/news/' . $model->provider_menu_logo,['style'=>'max-width:250px;max-height:250px;display: block;margin-top: 19px;','id'=>'user-photo-img']);
        echo $form->field($model,'provider_menu_logo')->fileInput(['accept' => 'image/*']);
        ?>
        <script type="text/javascript">
            function removeImage2() {
                $('#user-photo-img').attr('src','<?= Yii::$app->request->baseUrl.'/uploads/users/' ;?>');
                $("input[name='old_image2']").val('');
            };
        </script>
    </div>
    <input type="hidden" name="old_image2" value="<?= $model->provider_menu_logo ?>">
    <br/>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Add Provider') : Yii::t('app', 'Edit Provider'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
