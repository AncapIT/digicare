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

<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_title')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'user_id')->textInput() ?>
    
    <?php 
	    	$data =  array();  
	$sql =  "SELECT * FROM  cl_users  WHERE  user_role =  4  ";
	 if( $provider_id > 0 ) {   $sql .= " AND provider_id  = " . $provider_id ; }
    $res = Yii::$app->db->createCommand( $sql )->queryAll();
    foreach ( $res as $row ) { 	 $data[ $row["user_id"] ] =  $row["last_name"] ." ". $row["first_name"];  }
		
		
	     // SELECT LIST -  TYPE 
	    echo $form->field( $model, 'user_id' )->widget(Select2::classname(), [
	    'data' =>  $data,
	    'language' => 'en',
	    'options' => ['placeholder' => 'Select ...'],
	    'pluginOptions' => [
	        'allowClear' => true  
			],
	  ]); // END - SELECT LIST 
	  ?>
    <?php // SELECT LIST -  TYPE
	    echo $form->field( $model, 'product_id' )->widget(Select2::classname(), [
	    'data' =>  \app\models\Products::getListForDD(),
	    'language' => 'en',
	    'options' => ['placeholder' => 'Select ...'],
	    'pluginOptions' => [
	        'allowClear' => true
			],
	  ]);
	  ?>

    <?php // $form->field($model, 'product_type')->textInput(['maxlength' => true]) ?>
    
   <!-- --><?php /* // SELECT LIST -  TYPE
	    echo $form->field( $model, 'product_type' )->widget(Select2::classname(), [
	    'data' =>  $GLOBALS["product_type"],
	    'language' => 'en',
	    'options' => ['placeholder' => 'Select ...'],
	    'pluginOptions' => [
	        'allowClear' => true
			],
	  ]); // END - SELECT LIST 
	  */?>

    <?php // $form->field($model, 'selected_items')->textInput(['maxlength' => true]) ?>

    <?php // DATE AND TIME PICKER
    echo '<label class="control-label">'.Yii::t('app','Created').'</label>';
	echo DateTimePicker::widget([
        'model' => $model,
	    'attribute' => 'create_date',
	    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
	    'value' => $model->create_date,
	    'pluginOptions' => [
	        'autoclose'=>true,
	        'format' => 'yyyy-mm-dd HH:ii', 'startDate' => date('Y-m-d H:i:s')
	    ]
	]); ?>
 
    <?php // DATE AND TIME PICKER
    echo '<label class="control-label">'.Yii::t('app','Updated').'</label>';
	echo DateTimePicker::widget([
	    'model' => $model,
	    'attribute' => 'update_date',
	    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
	    'value' => $model->update_date,
	    'pluginOptions' => [
	        'autoclose'=>true,
	        'format' => 'yyyy-mm-dd HH:ii', 'startDate' => date('Y-m-d H:i:s')
	    ]
	]); ?>
	 
    <?= $form->field($model, 'price')->textInput() ?>

    <?php // $form->field($model, 'order_status')->textInput() ?>
     
     <?php  // SELECT LIST -  TYPE 
//	    echo $form->field( $model, 'order_status' )->widget(Select2::classname(), [
//	    'data' =>  $GLOBALS["order_status"],
//	    'language' => 'en',
//	    'options' => ['placeholder' => 'Select ...'],
//	    'pluginOptions' => [
//	        'allowClear' => true
//			],
//	  ]); // END - SELECT LIST
	  ?>
	  
	 
	 <?php
	 $orders_html = ''; 
	 $order_items =  $model->getOrder_items_data();
	 foreach ( $order_items as $order ) { 
		 $orders_html .= $order . '<br/><br/>'; 
	 }
	 if ( $orders_html != '' ) { 
		 echo '<hr/> <fieldset> <h3> '.Yii::t('app','Order Items').': </h3> <br/>' . $orders_html . '</fieldset>';
	 }
  ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
