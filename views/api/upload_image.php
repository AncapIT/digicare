<?php use app\components\DigiCareHelper;

error_reporting(0); date_default_timezone_set('CET');

 
   $request = Yii::$app->request; 
		
   $authToken = $request->post('authToken');   
   $user_id = $request->post('user_id');  
   $action = $request->post('action');    
		
	// ===================================================================================
	// ========================= Upload image 
	// ===================================================================================
	
	if ( $authToken && $user_id || 1 == 1) { 
			 
	$res = (new \yii\db\Query())
	->select(['*'])->from('cl_users')->where(['user_id' => $user_id, 'authToken' => $authToken, 'login_allowed' => 1  ])->all();
	foreach ( $res as $row ) {  $login =  $row['login'];  $provider_id = $row['provider_id'];   $user_photo = $row['photo'];   } 
			 
    if (  !empty($login) || 1 == 1  ) { 
	            
	    $result["status"] = 'ok';     
				 
   		$target_path =  Yii::$app->basePath . '/web/uploads/users/';  
   		$filename = $_FILES['wpua-file']['name'];

        if($action == 'update_user_photo'){
            $uploadfile = $target_path .$user_id.'-'. basename($_FILES['wpua-file']['name']);
            copy($uploadfile,$target_path .$user_id.'-original-'.basename($_FILES['wpua-file']['name']));
                     }else{
            $uploadfile = $target_path . basename($_FILES['wpua-file']['name']);
        }
				
				// --------------- try load and copy file --------------------------------
				
				if ( move_uploaded_file( $_FILES['wpua-file']['tmp_name'], $uploadfile)) {

				   $result["updated"] = true ;

				    // -----------------  RESIZE IMAGE ------------------       
					
					$width = 400; $height = 400; // resize max size in pixels
                    DigiCareHelper::resizeImage($width,$height,$uploadfile);
                    // ---------- update user photo field in database
				if ( $action == 'update_user_photo') {  update_user_photo( $uploadfile, $filename, $user_id );  }	  
				     
				} else {
				    
				   $result["mess"] =  "upload error";     
				}
		  
		
		       } else {   $error = "Incorrect authToken" ;  }
             
     } else {  $error = "Missed authToken" ;   }
		
		 
		 
		 
	function update_user_photo( $uploadfile, $filename, $user_id ) { 
		if($filename == ''){
		    $filename = 'def_img.png';
        }
		$sql =  " UPDATE `cl_users` SET photo = '". $filename ."' WHERE  user_id = '".$user_id."'   ";
		$res = Yii::$app->db->createCommand( $sql )->execute();
 				
	}	 // update_user_photo 
		 
			 
		 //  ------------------------------ OUTPUT DATA ------------------------	 

if (!empty($error)) {
     if ( $error ) {  $result["error"] = $error; 	Yii::$app->getResponse()->setStatusCode(401);  }
}

if (!empty($result)) {
    echo json_encode( $result, JSON_UNESCAPED_UNICODE );
}

        
?>