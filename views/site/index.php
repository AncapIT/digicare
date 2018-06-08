<?php

use app\assets\AppAsset;
use app\models\Providers; 

if ( !Yii::$app->user->isGuest ) {

AppAsset::register($this);  

$user_id =  Yii::$app->user->identity->user_id;	
$user_role =  Yii::$app->user->identity->user_role;
$provider_id =  Yii::$app->user->identity->provider_id; 
  
if (  $user_role  > 1  ) {  echo '<h1>'.Yii::t('app','Sorry, you are not authorized to access this system').'</h1>'; }  else {
	
$this->title = Yii::t('app','DigiCare Home');


	// ----------------------------------------------------------------------------------- // 
    // ------------------------------  COUNT DASHBOARD ITEMS 
    // ----------------------------------------------------------------------------------- //
	
	function countItems( $flag )
    { 
	    $user_id =  Yii::$app->user->identity->user_id;	
		$user_role =  Yii::$app->user->identity->user_role;   
	    $item_count = 0;  
	    $provider_id = 0;
	    
	    if ( $user_role == 1 ) {  
		    
		    $provider_id =  Yii::$app->user->identity->provider_id; 
		}
	    
	    if( $flag == 'users' ) { 
		     
		    $sql =  "SELECT * FROM cl_users WHERE login_allowed = 1 " ;
		    if( $provider_id > 0 ) {   $sql .= " AND provider_id  = " . $provider_id ; }
		    
			$res = Yii::$app->db->createCommand( $sql )->queryAll();
		    foreach ( $res as $row ) { $item_count++;  }
		 }
		 
		if( $flag == 'providers' ) { 
		    
		    $result = (new \yii\db\Query())
		    ->select(['*' ])->from( 'cl_providers' )->all(); 
		    foreach ( $result as $row ) { $item_count++;  }
		    
		    if( $provider_id > 0 ) {  $item_count = 1;  } 
		 }
	    
	    if( $flag == 'orders' ) { 
		    
		     $sql =  "SELECT * FROM cl_providers WHERE status = 0  ";
		     if( $provider_id > 0 ) {   $sql .= " AND provider_id  = " . $provider_id ; }
			 $res = Yii::$app->db->createCommand( $sql )->queryAll();
			 foreach ( $res as $row ) {    ; 
					
				 $sql2 =  "SELECT count(*) as n FROM cl_" . $row['provider_id'] ."_orders WHERE order_status in (1,2) AND user_id > 0 AND product_module != 'food_menu' ";
				 $res2 = Yii::$app->db->createCommand( $sql2 )->queryAll();
				 foreach ( $res2 as $row2 ) { $item_count+= $row2['n'];   }
				 	 
			 }
		
		}
		
		if( $flag == 'products' ) { 
		    
		    $sql2 =  "SELECT * FROM cl_" . $provider_id."_products    ";
			$res2 = Yii::$app->db->createCommand( $sql2 )->queryAll();
			foreach ( $res2 as $row2 ) { $item_count++;   }
		 }

		if( $flag == 'messages' ) {
            $item_count = \app\models\Messages::find()->joinWith('user')->where(['read_by_admin' => 0 , 'provider_id' => $provider_id])->count();
//		    $sql2 =  "SELECT * FROM cl_" . $provider_id."_products    ";
//			$res2 = Yii::$app->db->createCommand( $sql2 )->queryAll();
//			foreach ( $res2 as $row2 ) { $item_count++;   }
		 }
	     
	    return  $item_count; 
			    
	 }
	 
	 $provider_title = ''; 
	 if ( $provider_id > 0 ) { 
		 
		 $Providers = new Providers();
		 $provider_data = $Providers->find()->where(['provider_id' => $provider_id  ])->one();
		 $provider_title =  ": '" . $provider_data["provider_title"] . "'";  
		 
	 }

?>

<div class="site-index">
    
    <div class="body-content">
	    
	      <h1><?= Yii::t('app','DigiCare Dashboard')?> <?php if ( $provider_id > 0 ) { echo  $provider_title ; } ?> </h1>
	      
	      <p>
		      &nbsp;
	      </p>
          
          <?php if ( $user_role  == 1 ) {  ?>
            
         <div class="row" id="big_icons_block" style="width: 100%;text-align: center">
             <div class=" text-center" style="display: inline-block;">
                 <div class="big_icons">
                     <div id="big_icon_3" class="inner_icon"> </div>
                     <div class="inner_block">
                         <span class="text"><?= Yii::t('app','New Orders')?>: </span>
                         <span class="nums"><?=  countItems( 'orders' ); ?></span>
                         <br/>
                         <button data-link="orders/new_orders" class="index_btns" type="button"><?= Yii::t('app','Orders List')?></button>
                     </div>
                 </div>
             </div>
			   
			  <div class=" text-center" style="display: inline-block;">
				  <div class="big_icons">
						<div id="big_icon_2" class="inner_icon"> </div>	
						<div class="inner_block">  
							<span class="text"><?= Yii::t('app','New messages:')?> </span> <span class="nums"><?=  countItems( 'messages' ); ?></span> <br/>
                            <button data-link="messages/index?view=new" class="index_btns" type="button"><?= Yii::t('app','Messages List')?></button>
						</div> 
				  </div>
			  </div> 
			   

		</div>
		
		<?php } ?>
		
		
		
		
		<?php if ( $user_role  == 0 ) {  ?>
            
         <div class="row text-center" id="big_icons_block ">
			  
			   
			  <div class="col-md-12 text-center">
				  <div class="big_icons text-center" style="margin: auto;">
						<div id="big_icon_2" class="inner_icon"> </div>	
						<div class="inner_block">  
							<span class="text"><?= Yii::t('app','Total Providers:')?> </span> <span class="nums"><? echo countItems( 'providers' ); ?></span> <br/> <button data-link="providers/create" class="index_btns" type="button"><?= Yii::t('app','Add Provider')?></button>
						</div> 
				  </div>
			  </div> 
			    
		</div>
		
		<?php } ?>
		 
    </div>
</div>


<?php }
	
}	 
?> 
