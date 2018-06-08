<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$provider_id =  Yii::$app->user->identity->provider_id;
$user_role =  Yii::$app->user->identity->user_role;

$request = Yii::$app->request; $pid =  $request->get('pid');   $add_item =  $request->get('add_item'); $dpi = $request->get('dpi');
if (  $user_role  > 0  ) {  $pid = $provider_id; } 

?>

<div class="products-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model,'module')->dropDownList(\app\models\Modules::getForProductsDD()) ?>
    <?= $form->field($model, 'product_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_desc')->textarea(['rows' => 6, 'class' => 'noeditor', 'style' => 'width: 100%; min-height: 100px;' ]) ?>
     
    <?php  // SELECT LIST    
	    echo $form->field( $model, 'icon' )->widget(Select2::classname(), [
	    'data' =>  $GLOBALS["big_menu_icons"],
	    'language' => 'en',
	    'options' => ['placeholder' => 'Select ...'],
	    'pluginOptions' => [
	        'allowClear' => true
			],
	  ]); // END - SELECT LIST 
	  ?>

    <?= $form->field($model,'published')->checkbox(['checked'=>'checked' ]) ?>

   
   
   
   
   <?php   /*  ----------------------------  FUNCTION ADD NEW ITEM ---------------------------------------  */ 
	   function add_prod_item( $product_item, $model, $pid ) {

	       ?>
	   
	    <div class="row">
			    <div class="col-md-8 text-left product_item"> 
				    <input type="hidden" class="prod_item_id" value="<?= @$product_item["prod_item_id"];  ?>">
				    <a href="#" class="red_close_icon" onclick="return false;"> <i class="icon ion-close-circled"></i> </a>
				    <div class="form-group">
						<label class="control-label"><?= Yii::t('app','Item title')?></label>
						<input type="text"  class="form-control item_title" placeholder="Input Item title" name="item_title[<?= @$product_item["prod_item_id"];  ?>]" value="<?= @$product_item["title"];  ?>" >
				    </div>
				    <div class="form-group">
						<label class="control-label"><?= Yii::t('app','Description')?></label><br/>
						<textarea class="item_description" style="width: 100%; min-height: 100px; " placeholder="Input Description new Item" name="item_description[<?= @$product_item["prod_item_id"];  ?>]"><?= @$product_item["description"];  ?></textarea>
				  	</div> 
				  	 <div class="row"> 
					  	 
					  	 <div class="col-md-6 text-left">
					  	 	<label class="control-label"><?= Yii::t('app','Mandatory')?>
					  	 	<input type="checkbox" class="item_mandatory" value="y" name="item_mandatory[<?= @$product_item["prod_item_id"];  ?>]"
					  	 	<?php if( @$product_item["mandatory"] == 'y' ) { ?> checked="checked" <?php } ?> >
					  	 	</label>
					  	 </div> <!-- /. col -->
					  	 <div class="col-md-2 text-right sit_price sit_text_<?= @$product_item["prod_item_id"];  ?>
					  	 sit_datetime_<?= @$product_item["prod_item_id"];  ?>
					  	 sit_items_<?= @$product_item["prod_item_id"];?>"  <?php  if ( @$product_item["product_item_type"] == 'multi_choice' || @$product_item["product_item_type"] == 'single_choice' )
                             echo ' style="display:none" '?>>
					  	 	<b>Price</b>
					  	 </div> <!-- /. col -->
					  	 <div class="col-md-4 text-right sit_price sit_text_<?= @$product_item["prod_item_id"];  ?>
					  	 sit_datetime_<?= @$product_item["prod_item_id"];  ?>
					  	 sit_items_<?= @$product_item["prod_item_id"];  ?>" <?php  if ( @$product_item["product_item_type"] == 'multi_choice' || @$product_item["product_item_type"] == 'single_choice' )
                         echo ' style="display:none" '?> >
					  	 	 <input type="text" value="<?= @$product_item["price"];  ?>" class="item_price" name="item_price[<?= @$product_item["prod_item_id"];  ?>]" style="max-width: 80px;"> &euro;
					  	 </div> <!-- /. col -->
					</div> <!-- /. row --> 
					<br/>
					
					 <div class="row">  	 
					  	 <div class="col-md-6 text-left">
					  	 	<label class="control-label"> <?= Yii::t('app','Product Item Type')?></label>
					  	 </div> <!-- /. col -->
					  	 <div class="col-md-4 text-right"> 
						  	 
						  	 <select item_id="<?= @$product_item["prod_item_id"]?>" name="item_type[<?= @$product_item["prod_item_id"]; ?>]" class="select_item_type" id="select_item_type">
							  	  <option value="text" <?php if ( @$product_item["product_item_type"] == 'text' ) { ?> selected="selected" <?php } ?> > text </option>
							  	  <option value="single_choice" <?php if ( @$product_item["product_item_type"] == 'single_choice' ) { ?> selected="selected" <?php } ?>> single_choice </option>
							  	  <option value="multi_choice" <?php if ( @$product_item["product_item_type"] == 'multi_choice' ) { ?> selected="selected" <?php } ?>> multi_choice </option>
							  	  <option value="datetime" <?php if ( @$product_item["product_item_type"] == 'datetime' ) { ?> selected="selected" <?php } ?>> datetime </option>
                                 <option value="date" <?php if ( @$product_item["product_item_type"] == 'date' ) { ?> selected="selected" <?php } ?>> date </option>
                             </select>
						    	 
						 </div> <!-- /. col --> 
						 <div class="col-md-2 sit_single_multi text-left sit_single_choice_<?= @$product_item["prod_item_id"];  ?>
						  sit_multi_choice_<?= @$product_item["prod_item_id"];  ?>
						   sit_items_<?= @$product_item["prod_item_id"];  ?> sit_add_link"
                            <?php  if ( @$product_item["product_item_type"] != 'single_choice' && @$product_item["product_item_type"] != 'multi_choice' )
                         echo ' style="display:none" '?>> <a class="add_choice_link" href="#" onclick="return false;"> Add choice </a> </div>
						 	 
					</div> <!-- /. row --> 
					 <br/>
					 <div class="row " <?php
                      if ( /*@$product_item["product_item_type"] == 'text' || @$product_item["product_item_type"] == 'datetime'*/ 0 )
                          echo ' style="display:none" '?> >
					  	 <div class="col-md-6 text-left">
					  	 	 &nbsp;
					  	 </div> <!-- /. col -->
					  	 <div class="col-md-4 text-right">
					  	 	<label class="control-label"> <?= Yii::t('app','Sort Order')?> </label>
					  	 </div> <!-- /. col -->
					  	 <div class="col-md-2 text-left">
						   	 
						  	<select name="sort_items[<?= @$product_item["prod_item_id"]; ?>]" class="sort_items">
							  	  <?php $num = 1; while( $num <= 20 ) { ?>
							  	  <option value="<?= $num ?>" <?php if( @$product_item["sort_id"] == $num ) { ?> selected="selected" <?php } ?> ><?= $num ?></option>
							  	  <?php $num++; } ?>
						  	</select>
						    	  
						 </div> <!-- /. col --> 
					 	
					 	
					 	<br clear="all"/>
					 	<?php if ( @$product_item["product_item_type"] == 'single_choice' || @$product_item["product_item_type"] == 'multi_choice' ) { ?>
					 	<?php $sql =  "SELECT * FROM cl_".$pid."_prod_item_choices  WHERE  prod_item_id = '".@$product_item["prod_item_id"]."'  ORDER BY sort_id ASC ";
						   $res = Yii::$app->db->createCommand( $sql )->queryAll();
						   foreach ( $res as $row ) { 	   
						    ?> 
						   <table class="choice_proto sit_single_multi sit_single_choice_<?= @$product_item["prod_item_id"];  ?>
					  sit_multi_choice_<?= @$product_item["prod_item_id"];  ?> sit_items_<?= @$product_item["prod_item_id"];  ?>"><tr>
								<td align="left" width="10%"> <input type="text" class="ic_sort" name="ic_sort[<?= @$product_item["prod_item_id"];  ?>][]"
								 value="<?=  $row['sort_id'];  ?>" placeholder="Sort"> </td>
								<td align="left" width="40%"> <input type="text" class="ic_title" name="ic_title[<?= @$product_item["prod_item_id"];  ?>][]"
								value="<?=  $row['title'];  ?>" placeholder="Choice Title"> </td>
								<td align="left" width="40%"> <input type="text" class="ic_desc" name="ic_desc[<?= @$product_item["prod_item_id"];  ?>][]"
									value="<?=  $row['description'];  ?>" placeholder="Choice Desc"> </td>
								<td align="left" width="20%"> <input type="text" class="ic_price" name="ic_price[<?= @$product_item["prod_item_id"];  ?>][]"
								value="<?=  $row['price'];  ?>" placeholder="Price"> </td>
								<td align="right" width="10%"> <span class="delete_choice"> <i class="icon ion-close-circled"></i>  </span> </td>
							</tr></table>
							<?php } ?>
					 	<?php } ?>
					 	<div class="choice_proto_placeholder sit_single_multi sit_single_choice_<?= @$product_item["prod_item_id"];  ?>
					  sit_multi_choice_<?= @$product_item["prod_item_id"];  ?> sit_items_<?= @$product_item["prod_item_id"];  ?>"></div>
					 	
					 	 
					</div> <!-- /. row --> 
					 	 
				</div> <!-- /. col -->
            <script type="text/javascript">
                function organizeInputs(selected,id) {
                    console.log(selected);
                    console.log(id);

                    if(selected =="text"){
                        $('.sit_items_'+id).hide();
                        $('.sit_text_'+id).show();
                    }else if(selected == "single_choice"){
                        $('.sit_items_'+id).hide();
                        $('.sit_single_choice_'+id).show();
                    }else if(selected == "multi_choice"){
                        $('.sit_items_'+id).hide();
                        $('.sit_multi_choice_'+id).show();
                    }else if(selected == 'datetime' || selected == 'date'){
                        $('.sit_items_'+id).hide();
                        $('.sit_datetime_'+id).show();
                    }

                }
            /*    $('.select_item_type').change( function () {
                    var selected = $(this).val();
                    var id = $(this).attr('item_id');
                    console.log(selected);
                    console.log(id);
                    organizeInputs(selected,id)
                });*/

                //$(".sit_add_link").hide();

            </script>
	    </div>
	    <br/>
	    <?php  } ?>
	    
	    
	    
	    
	    
    
    <div class="row top_btn_line">
		<div class="col-md-2 text-left">  
			<a id="add_product_item" class="btn btn-primary orange_button plus_icon" href="#" onclick="return false;"><?= Yii::t('app','Add Item')?></a>
		</div>
		<div class="col-md-8 text-center"> <h4> <?= Yii::t('app','Product Items')?> </h4>  </div>
	</div>	
    <hr/>
    
    
    
    <div id="product_items_block">
	    
	    <div id="new_product_items_block"> </div> 
	    
	     <?php   $product_item = array();
		    
		      
		  /*  ----------------------------  LOAD EXIST PRODUCT ITEMS ---------------------------------------  */ 

		  if( isset($model->prod_id) && is_numeric($model->prod_id)){


	       $sql =  "SELECT * FROM  cl_".$provider_id."_product_items WHERE product_id = " . $model->prod_id . " ORDER BY sort_id ASC  ";
		   $res = Yii::$app->db->createCommand( $sql )->queryAll();
		   foreach ( $res as $row ) { 
			   	 
			    $product_item[ $row['prod_item_id'] ]["prod_item_id"] =  $row['prod_item_id'] ; 
			    $product_item[ $row['prod_item_id'] ]["sort_id"] =  $row['sort_id'] ; 
			    $product_item[ $row['prod_item_id'] ]["product_item_type"] =  $row['product_item_type'] ; 
			    $product_item[ $row['prod_item_id'] ]["mandatory"] =  $row['mandatory'] ; 
			    $product_item[ $row['prod_item_id'] ]["title"] =  $row['title'] ; 
			    $product_item[ $row['prod_item_id'] ]["description"] =  $row['description'] ;
			    $product_item[ $row['prod_item_id'] ]["price"] =  $row['price'] ;  
			    
			    add_prod_item( $product_item[ $row['prod_item_id'] ] , $model, $pid );
		   	}
		    //echo '<pre>' . var_dump( $product_item ). '</pre>';
         }
	?>	 
	      	
    </div>  <!-- /. product_items -->  
    
   
   
  
		
    <br/><br/>
     <?= $form->field($model, 'sort_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>










    <?php ActiveForm::end(); ?>

 <!-- =================== add_item_prototype --> 
   
    <div id="add_item_prototype">
	    <?php 
		          $product_item["prod_item_id"] =  0; 
				  $product_item["sort_id"] =  0 ; 
				  $product_item["product_item_type"] =  'text' ; 
				  $product_item["mandatory"] =  'n'; 
				  $product_item["title"] =  ''; 
				  $product_item["description"] =  '' ; 
				  $product_item["price"] =  '' ; 
				  
				   add_prod_item( $product_item, $model, $pid );  
	    ?>
    </div> <!-- /. add_item_prototype --> 


	<!-- =================== item_choice_prototype --> 

	<div id="item_choice_prototype">
		<table class="choice_proto"><tr>
			<td align="left" width="10%"> <input type="text" class="ic_sort" name="ic_sort" value="1" placeholder="Sort"> </td>
			<td align="left" width="40%"> <input type="text" class="ic_title" name="ic_title" value="" placeholder="Choice Title"> </td>
			<td align="left" width="40%"> <input type="text" class="ic_desc" name="ic_desc" value="" placeholder="Choice Desc"> </td>
			<td align="left" width="20%"> <input type="text" class="ic_price" name="ic_price" value="" placeholder="Price"> </td>
			<td align="right" width="10%"> <span class="delete_choice"> <i class="icon ion-close-circled"></i>  </span> </td>
		</tr></table>
	      
    </div> <!-- /. item_choice_prototype -->



     	
</div>
