<?php   error_reporting(0);
		
	// ===================================================================================
	// ========================= Method API for select personal notification for users
	// ===================================================================================
	
	
	    $request = Yii::$app->request; 
		
		$authToken = $request->post('authToken');   
		$user_id = $request->post('user_id'); 
		$patient_id =  $request->post('patient_id');  if( !$patient_id ) { $patient_id =  $user_id;  }   
 		
		//  ------------------------------ Check Input Data ------------------------  
		
		if ( $authToken && $user_id ) { 
			 
		    $res = (new \yii\db\Query())
		    ->select(['*'])->from('cl_users')->where(['user_id' => $user_id, 'authToken' => $authToken, 'login_allowed' => 1  ])->all();
		    foreach ( $res as $row ) {  
			      
			      $login =  $row['login']; 
		    } 
		    

            if (  !empty($login)  ) {    // if valid security token
					
				   $result["status"] = 'ok';  $num = 1; 
					 
				   // Select last 3 notifications for this user, which didt't read yet	 
				   
                   $sql =  "SELECT * FROM cl_push  WHERE user_id = '".$patient_id."' AND status = '0' ORDER BY created_time DESC LIMIT 0,3 ";
				   $res = Yii::$app->db->createCommand( $sql )->queryAll();
				   foreach ( $res as $row ) { 	  
					   
					   	$result["mess_list"][ $num ]["push_title"] =  $row['push_title'];
					   	$result["mess_list"][ $num ]["push_type"] =  $row['push_type'];
					   	$result["mess_list"][ $num ]["created_time"] =  $row['created_time'];  
					   	$result["mess_list"][ $num ]["pid"] =  $row['pid'];  
					   	
					   	$num++; }
				   

                } else {   $error = "Incorrect authToken" ;  }
             
		} else {  $error = "Enter authToken" ;   }
		 
		 
		 
			 
		 //  ------------------------------ OUTPUT DATA ------------------------	 

if (!empty($error)) {
    if ( $error ) {  $result["error"] = $error; 	Yii::$app->getResponse()->setStatusCode(401);  }
}

if (!empty($result)) {
    echo json_encode( $result, JSON_UNESCAPED_UNICODE );
}

        
?>