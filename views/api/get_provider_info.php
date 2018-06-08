<?php   error_reporting(0);
		
	// ===================================================================================
	// ========================= Load generall info about Provider
	// ===================================================================================
	
	$request = Yii::$app->request; 
		
	$authToken = $request->post('authToken');   
	$provider_id =  $request->post('provider_id');   
 		
    if (  $provider_id > 0  ) {    // if valid security token
					
		$result["status"] = 'ok';  
				 
		// ------------------------------------------
		// Select all  information about provider		 
			 	
		$res = (new \yii\db\Query())
		->select(['*'])->from('cl_providers')->where(['provider_id' => $provider_id, 'login_allowed' => 0  ])->all();
		foreach ( $res as $row ) {  
					
					$stripe_currency = $row['stripe_currency']; if ( !$stripe_currency || $stripe_currency == '' ) { $stripe_currency = 'sek'; } 
				    
				    $result["provider_title"] =  $row['provider_title'];
				    $result["provider_logo"] =  $row['provider_logo'];
				    $result["provider_menu_logo"] =  $row['provider_menu_logo'];
				    $result["color_model"] =  $row['color_model'];
				    $result["provider_info"] =  $row['provider_info'];
				    $result["currency"] =  $row['currency'];
				    $result["stripe_currency"] =  $stripe_currency ; 
				    $result["currency_place"] =  $row['currency_place'];
				    
		}
		 
	} 
		 
		 
		 
			 
		 //  ------------------------------ OUTPUT DATA ------------------------	 

if (!empty($error)) {
    if ( $error ) {  $result["error"] = $error; 	Yii::$app->getResponse()->setStatusCode(401);  }
}

if (!empty($result)) {
    echo json_encode( $result, JSON_UNESCAPED_UNICODE );
}

        
?>