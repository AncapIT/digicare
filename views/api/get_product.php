<?php   error_reporting(0);
		
	// ===================================================================================
	// ========================= Get page Product Details
	// ===================================================================================
	
	
	    $request = Yii::$app->request; 
		
		$authToken = $request->post('authToken');   
		$user_id = $request->post('user_id');  
		$page_link = $request->post('page_link');  
		
 		
		//  ------------------------------ Check Input Data ------------------------  
		
		if ( $authToken && $user_id ) { 
			 
		    $res = (new \yii\db\Query())
		    ->select(['*'])->from('cl_users')->where(['user_id' => $user_id, 'authToken' => $authToken, 'login_allowed' => 1  ])->all();
		    foreach ( $res as $row ) {  $login =  $row['login'];  $provider_id = $row['provider_id'];   } 
			
		 
            if (  !empty($login) && $provider_id > 0 ) {    // if valid security token
					
		// Quick fix: if food_menu, get latest food_menu from db
		// Needs to be fixed in a more permanent way 
		if ($page_link == "food_menu") {
  			$sql =  "SELECT * FROM cl_". $provider_id ."_products WHERE `module`='". $page_link ."' AND published = 1  ORDER BY `prod_id` DESC LIMIT 1";
			$res = Yii::$app->db->createCommand( $sql )->queryAll();
			$page_link = $res[0]['prod_id'];
		}

					$result["status"] = 'ok';  
					
					// ------------------------------------------
					// Select all information about active menu items		 
						 	
					$sql =  "SELECT * FROM cl_". $provider_id ."_products  
					 WHERE `prod_id`=". $page_link ." AND published = 1  LIMIT 1 "; //$result["sql"] =  $sql;
					$res = Yii::$app->db->createCommand( $sql )->queryAll();
					foreach ( $res as $row ) { 	  
						   
						$result["product_title"] = $row['product_title']; 
						$result["product_desc"] = $row['product_desc'];
                        			$result["sort_id"] = $row['sort_id'];
						$result["product_id"] = $row['prod_id'];
					//	$result["product_type"] = $row['product_type'];
						
						
						$sql2 =  "SELECT * FROM cl_". $provider_id ."_product_items  WHERE  product_id = '". $row['prod_id'] ."' ORDER BY sort_id ASC ";
						$res2 = Yii::$app->db->createCommand( $sql2 )->queryAll();
						foreach ( $res2 as $row2 ) { 	  
						    
						   
							$result["items"][ $row2['prod_item_id'] ]["title"] = $row2['title']; 
							$result["items"][ $row2['prod_item_id'] ]["description"] = $row2['description']; 
							$result["items"][ $row2['prod_item_id'] ]["price"] = $row2['price']; 
							$result["items"][ $row2['prod_item_id'] ]["mandatory"] = $row2['mandatory']; 
							$result["items"][ $row2['prod_item_id'] ]["item_id"] = $row2['prod_item_id']; 
							$result["items"][ $row2['prod_item_id'] ]["item_type"] = $row2['product_item_type'] ;
                            $result["items"][ $row2['prod_item_id'] ]["sort_id"] = $row2['sort_id'] ;
                            $result["items"][ $row2['prod_item_id'] ]["choices"] = array();
							
							$sql3 =  "SELECT * FROM cl_". $provider_id ."_prod_item_choices  WHERE  prod_item_id = '". $row2['prod_item_id'] ."' ORDER BY sort_id ASC ";
							$res3 = Yii::$app->db->createCommand( $sql3 )->queryAll();
							foreach ( $res3 as $row3 ) { 
						    		
						    		$result["items"][ $row2['prod_item_id'] ]["choices"][ $row3['id'] ]["title"] = $row3['title']; 
						    		$result["items"][ $row2['prod_item_id'] ]["choices"][ $row3['id'] ]["description"] = $row3['description']; 
						    		$result["items"][ $row2['prod_item_id'] ]["choices"][ $row3['id'] ]["prod_item_id"] = $row3['prod_item_id'];
                                $result["items"][ $row2['prod_item_id'] ]["choices"][ $row3['id'] ]["sort_id"] = $row3['sort_id'];
								$result["items"][ $row2['prod_item_id'] ]["choices"][ $row3['id'] ]["prod_item_choices_id"] = $row3['id'];
								$result["items"][ $row2['prod_item_id'] ]["choices"][ $row3['id'] ]["price"] = $row3['price'];
                            }
					} }
				 
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
