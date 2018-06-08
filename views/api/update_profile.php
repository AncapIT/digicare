<?php   error_reporting(0);  date_default_timezone_set('CET'); 
 
use yii\web\IdentityInterface;
 

	// ===================================================================================
	// ========================= Get Food Menu Items
	// ===================================================================================
	
	
	    $request = Yii::$app->request; 
		
		$authToken = $request->post('authToken');   
		$user_id = $request->post('user_id');  
		$patient_id = $request->post('patient_id');  
		
		$first_name = $request->post('first_name'); 
		$last_name = $request->post('last_name'); 
		$address = $request->post('address'); 
		$city = $request->post('city'); 
		$email = $request->post('email'); 
		$phone = $request->post('phone'); 
		$new_password =  $request->post('new_password'); 
		$old_password =  $request->post('old_password'); 
	   	
		//  ------------------------------ Check Input Data ------------------------  
		
		if ( $authToken && $user_id ) { 
			 
		    $res = (new \yii\db\Query())
		    ->select(['*'])->from('cl_users')->where(['user_id' => $user_id, 'authToken' => $authToken, 'login_allowed' => 1  ])->all();
		    foreach ( $res as $row ) {  $login =  $row['login'];   } 
			
		 
            if (  !empty($login)  ) {    // if valid security token
					
				$result["status"] = 'ok';   
				
				 	
				// ------------------------------------------
				// Update Profile fields for this Patient	
				 	
				$sql =  " UPDATE `cl_users` SET `first_name` = '".$first_name."', `last_name` = '".$last_name."', `address` = '".$address."', `city` = '".$city."', `email` = '".$email."', `phone` = '".$phone."' WHERE user_id = '". $patient_id ."' ";
				$res = Yii::$app->db->createCommand( $sql )->execute();
				
				
				// ------------------------------------------
				// Update Profile Password if it was changed	
				
				if ( $old_password ) { 
					 $user = \app\models\User::findOne($patient_id);
					 $user->new_password = $new_password;
					 $user->modifier = \app\models\User::findOne($user_id);
					 $user->save();
                    $error = $user->getErrors();
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