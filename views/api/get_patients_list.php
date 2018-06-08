<?php   error_reporting(0);
		
	// ===================================================================================
	// ========================= Method API for select patients list for Staff or Relative
	// ===================================================================================
	
	
	    $request = Yii::$app->request; 
		
		$authToken = $request->get('authToken');
		$user_id = $request->get('user_id');
 		
		//  ------------------------------ Check Input Data ------------------------  
		
		if ( $authToken && $user_id ) { 
			 
		    $res = (new \yii\db\Query())
		    ->select(['*'])->from('cl_users')->where(['user_id' => $user_id, 'authToken' => $authToken, 'login_allowed' => 1  ])->all();
		    foreach ( $res as $row ) {  
			      
			      $login =  $row['login'];
			      $result["provider_id"] =  $row['provider_id'];
			      $result["first_name"] =  $row['first_name'];
			      $result["last_name"] =  $row['last_name'];
			      $result["phone"] =  $row['phone'];
			      $result["email"] =  $row['email'];
			      $result["photo"] =  $row['photo'];
			      $result["lang"] =  $row['lang'];
		 	 } 
			
		 
            if (  !empty($login)  ) {    // if valid security token
					
				$result["status"] = 'ok';  $num = 0; 
					
				// select staff users group 
				$group_id = [];  $users_array = array();
				$res = (new \yii\db\Query())
			    ->select(['*'])->from('cl_group_members')->where(['user_id' => $user_id, 'group_type' => 'group'  ])->all(); 
			    foreach ( $res as $row ) {     $group_id[] =  $row['group_id']; }
				
				// step 1 - check bind user-to-user		
					   
                 $sql =  " SELECT * FROM `cl_group_members` as gm,  `cl_users` as u  WHERE   (  gm.parent_id <> '".$user_id."' AND gm.user_id = '".$user_id
                 ."' AND gm.user_id = u.user_id  AND gm.parent_id != 0  )  ";
                 
                 $res = Yii::$app->db->createCommand( $sql )->queryAll();
                 foreach ( $res as $row ) {   $users_array[] = $row['parent_id'];    }
                   
                
                // step 2 - check bind to users group 
                
                if ( count($group_id) > 0  ) {  $sql = "  SELECT * FROM `cl_group_members` as gm,  `cl_users` as u  WHERE  u.user_role = 4 AND  gm.group_id IN (".
	                					 implode(',',$group_id) .") AND gm.user_id = u.user_id  GROUP BY u.user_id  ";
                  
                  
				$res = Yii::$app->db->createCommand( $sql )->queryAll();  // $result["sql"] =  $sql; 
				foreach ( $res as $row ) {   
						$users_array[] = $row['user_id'];    
	                    $num++;   
	                }
	             }    
	                
	            $users_array =  array_unique( $users_array );
	            
	            foreach ( $users_array as $key => $user ) {    
	                    $result["patients"][ $key ] =  get_user_data( $user ) ;  
	                    
	            } 
	            
	            $result["patients"] = array_filter( $result["patients"] );
	                
				$result["patients_num"] =  count($result["patients"]);
                   

                } else {   $error = "Incorrect authToken" ;  }
             
		} else {  $error = "Enter authToken" ;   }
		
		 
		 
		// ------------------------------------------
		// Select all patients data by user_id
		 
		function get_user_data( $user_id ) { 
			
			 $res = (new \yii\db\Query())
		    ->select(['*'])->from('cl_users')->where([ 'user_id' => $user_id ])->all(); 
		    foreach ( $res as $row ) {   
			     
			     if ( !$row['photo'] || $row['photo'] == '' ) {  $photo = 'user_placeholder.png'; } else { $photo = $row['photo'];  }
			     
			     if( $row['first_name'] ) { $first_name = $row['first_name']; } else {  $first_name = ''; }
			     if( $row['last_name'] ) { $last_name = $row['last_name']; } else {  $last_name = ''; }
			     if( $row['phone'] ) { $phone = $row['phone']; } else {  $phone = ''; }
			     if( $row['email'] ) { $email = $row['email']; } else {  $email = ''; }
			     if( $row['address'] ) { $address = $row['address']; } else {  $address = ''; }
			     if( $row['city'] ) { $city = $row['city']; } else {  $city = ''; }
			     if( $row['lang'] ) { $lang = $row['lang']; } else {  $lang = ''; }
			     
			    	$patient_info["patient_id"] =  $row['user_id'];
			    	$patient_info["provider_id"] =  $row['provider_id'];
			    	$patient_info["first_name"] =  $first_name;
			    	$patient_info["last_name"] =  $last_name;
			    	$patient_info["phone"] =  $phone;
			    	$patient_info["email"] =  $email;
			    	$patient_info["address"] =  $address;
			    	$patient_info["city"] =  $city;
			    	$patient_info["photo"] =  $photo;
			    	$patient_info["lang"] =  $lang; 
			    	
			} 
			return $patient_info; 
		} 
		
		
		 
			 
		 //  ------------------------------ OUTPUT DATA ------------------------	 

if (!empty($error)) {
    if ( $error ) {  $result["error"] = $error; 	Yii::$app->getResponse()->setStatusCode(401);  }
}

if (!empty($result)) {
    echo json_encode( $result, JSON_UNESCAPED_UNICODE );
}

        
?>