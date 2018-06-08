<?php   error_reporting(0);
		
	// ===================================================================================
	// ========================= Method API for get last version code
	// ===================================================================================
	
	
	    $request = Yii::$app->request; 
		
		$authToken = $request->post('authToken');    
 		
		//  ------------------------------ Check Input Data ------------------------  
		
		if ( $authToken ) { 
			 
			$result["status"] = 'ok';   
				 		
					   
                 $sql =  " SELECT * FROM `cl_settings` WHERE setting = 'app_version_required'  LIMIT 1 ";
                 $res = Yii::$app->db->createCommand( $sql )->queryAll();
				 foreach ( $res as $row ) {   
	                    $result["app_version"] =  $row['value'] ;    
	             } 
             
             
		} else {  $error = "Enter authToken" ;   }
		
		 
		  
		 
			 
		 //  ------------------------------ OUTPUT DATA ------------------------	 

if (!empty($error)) {
    if ( $error ) {  $result["error"] = $error; 	Yii::$app->getResponse()->setStatusCode(401);  }
}

if (!empty($result)) {
    echo json_encode( $result, JSON_UNESCAPED_UNICODE );
}

        
?>