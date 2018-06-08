<?php   error_reporting(0);
		
	// ===================================================================================
	// ========================= Get Orders History for this Patient
	// ===================================================================================
	
	
	    $request = Yii::$app->request; 
		
		$authToken = $request->post('authToken');   
		$user_id = $request->post('user_id');     
		$patient_id = $request->post('patient_id');  
		
 		
 		//$result["tmp"] = $user_id ."-". $provider_id ."-". $patient_id  ; 
		//  ------------------------------ Check Input Data ------------------------  
		
		if ( $authToken && $user_id ) { 
			 
		    $res = (new \yii\db\Query())
		    ->select(['*'])->from('cl_users')->where(['user_id' => $user_id, 'authToken' => $authToken, 'login_allowed' => 1  ])->all();
		    foreach ( $res as $row ) {  $login =  $row['login'];  $provider_id = $row['provider_id'];   } 
			
		 
            if (  !empty($login) && $provider_id > 0 ) {    // if valid security token
					
					$result["status"] = 'ok';   $num = 0;
					
					// ------------------------------------------
					// Select all information about active menu items		 
						 	
					$sql =  "SELECT * FROM cl_". $provider_id ."_orders  WHERE  patient_id = '". $patient_id ."' ORDER BY order_id DESC  LIMIT 0,100 ";
				  	$res = Yii::$app->db->createCommand( $sql )->queryAll();
					foreach ( $res as $row ) { 	  
						   
						$result['orders'][ $num ]["order_title"] = $row['order_title']; 
						//$result['orders'][ $num ]["product_type"] = $row['product_type'];
						$result['orders'][ $num ]["price"] = $row['price']; 
						$result['orders'][ $num ]["order_status"] = $row['order_status'];
						$result['orders'][ $num ]["create_date"] = $row['create_date']; 
					    $result['orders'][ $num ]["selected_items"] = $row['selected_items']; 
						
					$num++; }
				 
                } else {   $error = "Incorrect authToken or missed Provider" ;  }
             
		} else {  $error = "Enter authToken" ;   }
		
		 
	   
		 //  ------------------------------ OUTPUT DATA ------------------------	 

if (!empty($error)) {
    if ( $error ) {  $result["error"] = $error; 	Yii::$app->getResponse()->setStatusCode(401);  }
}

if (!empty($result)) {
    echo json_encode( $result, JSON_UNESCAPED_UNICODE );
}

        
?>