<?php   error_reporting(0);
		
	// ===================================================================================
	// ========================= Get Food Menu Items
	// ===================================================================================
	
	
	    $request = Yii::$app->request; 
		
		$authToken = $request->post('authToken');   
		$user_id = $request->post('user_id');  
		$patient_id = $request->post('patient_id');  
		
 		
		//  ------------------------------ Check Input Data ------------------------  
		
		if ( $authToken && $user_id ) { 
			 
		    $res = (new \yii\db\Query())
		    ->select(['*'])->from('cl_users')->where(['user_id' => $user_id, 'authToken' => $authToken, 'login_allowed' => 1  ])->all();
		    foreach ( $res as $row ) {  $login =  $row['login'];   } 
			
		 
            if (  !empty($login)  ) {    // if valid security token
					
					$result["status"] = 'ok';  
					
					// ------------------------------------------
					// Select all information about this Patient		 
						 	
				 
						  $res = (new \yii\db\Query())
				    ->select(['*'])->from('cl_users')->where([ 'user_id' => $patient_id ])->all(); 
				    
				    foreach ( $res as $row ) {   
			    	$patient_info["patient_id"] =  $row['user_id'];
			    	$patient_info["provider_id"] =  $row['provider_id'];
			    	$patient_info["first_name"] =  $row['first_name'];
			    	$patient_info["last_name"] =  $row['last_name'];
			    	$patient_info["phone"] =  $row['phone'];
			    	$patient_info["email"] =  $row['email'];
			    	$patient_info["address"] =  $row['address'];
			    	$patient_info["city"] =  $row['city'];
			    	$patient_info["photo"] =  $row['photo'];
			    	$patient_info["lang"] =  $row['lang']; 
			    	
					}
					
					$result["patient_info"] =  $patient_info;
			
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