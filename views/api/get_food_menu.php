<?php   error_reporting(0);
		
	// ===================================================================================
	// ========================= Get Food Menu Items
	// ===================================================================================
	
	
	    $request = Yii::$app->request; 
		
		$authToken = $request->post('authToken');   
		$user_id = $request->post('user_id');   
		$page_link = $request->post('page_link');  
		
 		
		//  ------------------------------ Check Input Data ------------------------  
		
		if ( $authToken && $user_id ) { 
			 
		    $res = (new \yii\db\Query())
		    ->select(['*'])->from('cl_users')->where(['user_id' => $user_id, 'authToken' => $authToken, 'login_allowed' => 1  ])->all();
		    foreach ( $res as $row ) {  $login =  $row['login'];   $provider_id = $row['provider_id'];  } 
			
		 
            if (  !empty($login) && $provider_id > 0 ) {    // if valid security token
					
					$result["status"] = 'ok';  
					
					// ------------------------------------------
					// Select all information about active menu items		 
						 	
					$sql =  "SELECT * FROM cl_". $provider_id ."_products p 
				   where `module` LIKE 'food_menu' AND published = 1  LIMIT 1 ";
					$res = Yii::$app->db->createCommand( $sql )->queryAll();
					foreach ( $res as $row ) { 	  
						   
						$result["product_title"] = $row['product_title']; 
						$result["product_desc"] = $row['product_desc']; 
						$result["visit_date"] = $row['visit_date']; 
						$result["from_date"] = $row['from_date']; 
						$result["to_date"] = $row['to_date']; 
						$result["price"] = $row['price']; 
						$result["comment"] = $row['comment']; 
						$result["icon"] = $row['icon'];
						$result["sort_id"] = $row['sort_id'];
						$result["food_menu"] = $row['food_menu'];  
					}
				 
                } else {   $error = "Incorrect authToken or missed Provider" ;  }
             
		} else {  $error = "Enter authToken and user_id" ;   }
		
		 
	   
		 //  ------------------------------ OUTPUT DATA ------------------------	 

if (!empty($error)) {
    if ( $error ) {  $result["error"] = $error; 	Yii::$app->getResponse()->setStatusCode(401);  }
}

if (!empty($result)) {
    echo json_encode( $result, JSON_UNESCAPED_UNICODE );
}

        
?>