<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;  

use kartik\select2\Select2;
use kartik\file\FileInput; 
use yii\bootstrap\Modal; 
use kartik\datetime\DateTimePicker;

?>

<div class="items-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'doc_id')->hiddenInput() ?>

     <?   // SELECT LIST -  TYPE 
	    echo $form->field( $model, 'doc_type' )->widget(Select2::classname(), [
	    'data' =>  $GLOBALS["document_types"],
	    'language' => 'en',
	    'options' => ['placeholder' => Yii::t('app','Select ...')],
	    'pluginOptions' => [
	        'allowClear' => true
			],
	  ]); // END - SELECT LIST 
	  ?>

    <?// $form->field($model, 'item_date')->textInput() ?>
    
     <?  // DATE AND TIME PICKER
    echo '<label class="control-label">'.Yii::t('app','Item Date').'</label>';
	echo DateTimePicker::widget([
	    'name' => 'item_date',
	    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
	    'value' => $model->item_date,
	    'pluginOptions' => [
	        'autoclose'=>true,
	        'format' => 'yyyy-mm-dd HH:ii', 'startDate' => date('Y-m-d H:i:s')
	    ]
	]); ?>

    <?= $form->field($model, 'item_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'item_header')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'item_content')->textarea(['rows' => 6]) ?>
  
    <?= $form->field($model, 'pdf_link')->textInput(['maxlength' => true]) ?>

   <?  // Display an initial preview of files with caption 
		
		echo $form->field($model, 'image')->widget(FileInput::classname(), [
		    'name' => 'image',
		    'options'=>[
		        'multiple'=>false, 'accept' => 'image/*'
		    ],
		    'pluginOptions' => [
		        'initialPreview'=>[
		            "http://" . Yii::$app->getRequest()->serverName . '/web/uploads/news/' . $model->image 
		        ],
		        'initialPreviewAsData'=>true, 
		        'initialPreviewConfig' => [
		            ['caption' => 'Document Item Photo'],
		        ],
		        'overwriteInitial'=>false,
		        'maxFileSize'=>2800
		    ]
		]);  ?>
		<input type="hidden" name="old_image" value="<?= $model->image ?>">
	 <br/>
	 
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
