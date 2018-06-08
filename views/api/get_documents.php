<?php   error_reporting(0);
		
	// ===================================================================================
	// ========================= Get documents List and Single view
	// ===================================================================================
	
	
	    $request = Yii::$app->request; 
		
		$authToken = $request->post('authToken');   
		$user_id = $request->post('user_id'); 
		$task = $request->post('task'); 
		$doc_type = $request->post('doc_type');    
		$item_id = $request->post('item_id');
		$patient_id = $request->post('patient_id'); if ( !$patient_id ) { $patient_id = '*'; }
 		 
 		// $result["temp"] = $task ."-". $item_id ."-". $doc_type   ; 
 		  
		//  ------------------------------ Check Input Data ------------------------  
		
		if ( $authToken && $user_id ) { 
			 
		    $res = (new \yii\db\Query())
		    ->select(['*'])->from('cl_users')->where(['user_id' => $user_id, 'authToken' => $authToken, 'login_allowed' => 1  ])->all();
		    foreach ( $res as $row ) {  $login =  $row['login'];  $provider_id = $row['provider_id'];   } 
			 
			 
            if (  !empty($login) ) {    // if valid security token
					 
					 
					// ------------------------------------------
					// Select list inner page items 
					
					if ( $task == 'view-list' && $provider_id > 0  && $patient_id ) {    
					 
					 	$result["status"] = 'ok';  
					   	
				    $sql =  "SELECT * FROM cl_". $provider_id ."_documents  WHERE  doc_type LIKE '".$doc_type."' AND category_desc = 'y' AND published = 1 AND ( user_id = '".$patient_id."' OR user_id = '0' )  ORDER BY doc_date DESC LIMIT 1 ";
				    $res = Yii::$app->db->createCommand( $sql )->queryAll();  
				    foreach ( $res as $row ) { 	  
					  
					    $result["doc_title"] = $row['doc_title'];
					   	$result["doc_header"] = $row['doc_header'];
					   	$result["doc_content"] = $row['doc_content'];
					   	
					   	$num = 0; 
					   	
					   	$result["items"] = array();
					   	
					   	//................ GEt inner document items: 
					   	 $sql2 =  "SELECT * FROM cl_". $provider_id ."_documents WHERE  doc_type LIKE '".$doc_type."' AND category_desc = 'n'  AND published = 1 AND ( user_id = '".$patient_id."' OR user_id = '0' )   ORDER BY doc_date DESC LIMIT 0,20 ";
					   	 $res2 = Yii::$app->db->createCommand( $sql2 )->queryAll(); 
					   	 foreach ( $res2 as $row2 ) { 
						   	 
						   	 $result["items"][ $num ]["item_id"] = $row2['doc_id'];
						   	 $result["items"][ $num ]["item_date"] = $row2['doc_date'];
						   	 $result["items"][ $num ]["item_title"] = $row2['doc_title'];
						   	 $result["items"][ $num ]["image"] = $row2['doc_image'];
						   	 //$result["items"][ $num ]["content"] = $row2['doc_content']; 
						
						$num++; } 	 
					   }
                    } // end - list view
                    
                   
                    
                    
                    
                    // ------------------------------------------
					// single view for item_id
					
					if ( $task == 'view-details' && $provider_id > 0 && ( $doc_type || $item_id  ) ) {  
						 
						 $result["status"] = 'ok';  
						 	
                    	 $sql2 =  "SELECT * FROM cl_". $provider_id ."_documents WHERE doc_id > 0  AND published = 1  ";
                    	 if( $doc_type != '' && $doc_type ) {  $sql2 .= " AND doc_type = '".$doc_type."' AND ( user_id = '".$patient_id."' OR user_id = '0' )  " ;  }
                    	 if( $item_id  > 0  ) {  $sql2 .= "  AND  doc_id = '".$item_id."'   ";  }
	                     
	                     $result["page_info"] = array();
	                      	 
					   	 $res2 = Yii::$app->db->createCommand( $sql2 )->queryAll();
					   	 foreach ( $res2 as $row2 ) { 
						    
						   	 $result["page_info"]["item_date"] = $row2['doc_date'];
						   	 $result["page_info"]["item_title"] = $row2['doc_title'];
						   	 $result["page_info"]["image"] = $row2['doc_image'];
						   	 $result["page_info"]["item_content"] = $row2['doc_content']; 
						   	 $result["page_info"]["item_header"] = $row2['doc_header']; 
						     $result["page_info"]["pdf_link"] = $row2['pdf_link']; 
						  } 	
                    	
                    } //  end - single view
                    
                    
                      
					
                } else {   $error = "Incorrect authToken" ;  }
             
		} else {  $error = "Missed authToken" ;   }
		
		 
		
		 
			 
		 //  ------------------------------ OUTPUT DATA ------------------------	 

if (!empty($error)) {
    if ( $error ) {  $result["error"] = $error; 	Yii::$app->getResponse()->setStatusCode(401);  }
}

if (!empty($result)) {
    echo json_encode( $result, JSON_UNESCAPED_UNICODE );
}

        
?>