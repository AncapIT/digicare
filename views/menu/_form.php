<?php


use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$request = Yii::$app->request; $pid =  $request->get('pid'); if( !$pid ) { $pid = 1;  } 

 // -------- check access level ---------
$provider_id =  Yii::$app->user->identity->provider_id;	
$user_role =  Yii::$app->user->identity->user_role;  
if ( $user_role > 0 && ( $pid != $provider_id )  ) {  echo '<h1>'.Yii::t('app','Access is denied!').'</h1>'; die();  }
// --- end - check access level

?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'menu_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_page')->textInput(['maxlength' => true]) ?> 
    
   
     <?   // SELECT LIST -  TYPE 
	    echo $form->field( $model, 'home_flag' )->widget(Select2::classname(), [
	    'data' =>  $GLOBALS["yn_status"],
	    'language' => 'en',
	    'options' => ['placeholder' => Yii::t('app','Select ...')],
	    'pluginOptions' => [
	        'allowClear' => true
			],
	  ]); // END - SELECT LIST 
	  ?> 

     
    <?   // SELECT LIST -  TYPE 
	    echo $form->field( $model, 'menu_icon' )->widget(Select2::classname(), [
	    'data' =>   $GLOBALS["big_menu_icons"],
	    'language' => 'en',
	    'options' => ['placeholder' => Yii::t('app','Select ...')],
	    'pluginOptions' => [
	        'allowClear' => true
			],
	  ]); // END - SELECT LIST 
	  ?>

    <?= $form->field($model, 'menu_link')->textInput(['maxlength' => true]) ?>

     <?   // SELECT LIST -  TYPE 
	    echo $form->field( $model, 'menu_type' )->widget(Select2::classname(), [
	    'data' =>  $GLOBALS["menu_type"],
	    'language' => 'en',
	    'options' => ['placeholder' => Yii::t('app','Select ...')],
	    'pluginOptions' => [
	        'allowClear' => true
			],
	  ]); // END - SELECT LIST 
	  ?> 
	  
    <?   // SELECT LIST -  TYPE 
	    echo $form->field( $model, 'status' )->widget(Select2::classname(), [
	    'data' =>  $GLOBALS["yn_status"],
	    'language' => 'en',
	    'options' => ['placeholder' => Yii::t('app','Select ...')],
	    'pluginOptions' => [
	        'allowClear' => true
			],
	  ]); // END - SELECT LIST 
	  ?> 

     <?   // SELECT LIST -  TYPE 
	    echo $form->field( $model, 'level' )->widget(Select2::classname(), [
	    'data' =>   $GLOBALS["user_role_codename"],
	    'language' => 'en',
	    'options' => ['placeholder' => Yii::t('app','Select ...')],
	    'pluginOptions' => [
	        'allowClear' => true
			],
	  ]); // END - SELECT LIST 
	  ?>
	
	<?= $form->field($model, 'sort_id')->textInput() ?>
	
    <?= $form->field($model, 'page_desc')->textarea(['rows' => 6]) ?>

     
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
