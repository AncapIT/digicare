<?php   error_reporting(0);
		
	// ===================================================================================
	// ========================= Get page Product List
	// ===================================================================================
	
	
	    $request = Yii::$app->request; 
		
		$authToken = $request->post('authToken');   
		$user_id = $request->post('user_id');  
		$parent_page = $request->post('parent_page');  
		
 		
		//  ------------------------------ Check Input Data ------------------------  
		
		if ( $authToken && $user_id ) { 
			 
		    $res = (new \yii\db\Query())
		    ->select(['*'])->from('cl_users')->where(['user_id' => $user_id, 'authToken' => $authToken, 'login_allowed' => 1  ])->all();
		    foreach ( $res as $row ) {  $login =  $row['login'];  $provider_id = $row['provider_id'];   } 
			
		 
            if (  !empty($login) && $provider_id > 0 ) {    // if valid security token
					
					$result["status"] = 'ok';  $num = 0;  
					
					// ------------------------------------------
					// Select all information about active menu items		 
					
					$sql =  "SELECT * FROM cl_". $provider_id ."_products p ". /*$parent_page .*/" 
					   where `module` = '". $parent_page ."'  AND published = 1 ORDER BY sort_id ASC  ";
					 
							   $res = Yii::$app->db->createCommand( $sql )->queryAll();
							   foreach ( $res as $row ) { 	  
						    
						   	$result["menu_items"][ $num ]["menu_title"] = $row['product_title'];
						   	$result["menu_items"][ $num ]["menu_icon"] =  $row['icon'];
						   	$result["menu_items"][ $num ]["menu_link"] =  $row['prod_id'];
                                   $result["menu_items"][ $num ]["sort_id"] =  $row['sort_id'];
						   	$result["menu_items"][ $num ]["menu_type"] =  'product';  
						   	$result["menu_items"][ $num ]["level"] =  'patient'; 
						   	
						   	$num++; }
					$result["sql"]  =  $sql;
						   	
					// Get parent Page info	 
					$sql =  "SELECT * FROM cl_". $provider_id ."_modules  WHERE  link LIKE '". $parent_page ."'  LIMIT 1  ";
					$res = Yii::$app->db->createCommand( $sql )->queryAll();
					foreach ( $res as $row ) { 	  
						   
						   	$result["title"]  = $row['module_name']; 
						   	$result["page_desc"]  = $row['comment'];  
					}  	
                   

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
