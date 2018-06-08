<?php   error_reporting(0);
		
	// ===================================================================================
	// ========================= Select all Homepage items for this Provider
	// ===================================================================================
	
	 $request = Yii::$app->request; 
		
	$authToken = $request->post('authToken');   
	$provider_id =  $request->post('provider_id');   
 		
    if (  $provider_id > 0  ) {    // if valid security token
					
		$result["status"] = 'ok';  $num = 0;
				 
		// ------------------------------------------
		// Select all information about active menu items		 
			 	
		$sql =  "SELECT * FROM cl_". $provider_id ."_modules  WHERE  status LIKE 'y' AND sub_module LIKE 'n' ORDER BY sort_order ASC  ";
				   $res = Yii::$app->db->createCommand( $sql )->queryAll();
				   foreach ( $res as $row ) { 	  
					    
					    $user_roles = explode( "|", $row['module_role_id'] );
					    $module_role_id = 'staff';
					    foreach( $user_roles as $role  ){  
						    if( $role == 4 ) { $module_role_id = 'patient';   } 
						}
                        $result["menu_items"][ $num ]["menu_title"] = $row['module_name'];
					   	$result["menu_items"][ $num ]["menu_icon"] =  $row['module_icon'];
					   	$result["menu_items"][ $num ]["menu_link"] =  $row['link'];
                        $result["menu_items"][ $num ]["sort_order"] =  $row['sort_order'];
					   	$result["menu_items"][ $num ]["menu_type"] =  $row['module_type'];  
					   	$result["menu_items"][ $num ]["level"] =  $module_role_id; 
					   	
					   	$num++; }
		 
	} 
		  
			 

	//  ------------------------------ OUTPUT DATA ------------------------	 
	
	if (!empty($error)) {
	    if ( $error ) {  $result["error"] = $error; 	Yii::$app->getResponse()->setStatusCode(401);  }
	}
	
	if (!empty($result)) {
	    echo json_encode( $result, JSON_UNESCAPED_UNICODE );
	}

        
?>