<?php   error_reporting(0);
	
	// ===================================================================================
	// ========================= Method API for check login params and get user level 
	// ===================================================================================
	
	    unset( $error );
		$request = Yii::$app->request; 
		
		$login = $request->post('login');   $password = $request->post('password');
$user_id = '';
// if success
		if ( $login &&  $password ) { 
			
			$user_password = ''; $user_role = '';   $user_role_title = '';
			
			$res = (new \yii\db\Query())
		    ->select(['*'])->from('cl_users')->where(['login' => $login, 'login_allowed' => 1 ,'login_username'=>1 ])->all();
		    foreach ( $res as $row ) {  $user_password =  $row['password'];  $user_role =  $row['user_role'];  $user_id =  $row['user_id'];   } 
	
		    // Temp fix to allow admin access to app - report users with role Admin as role Staff
		    if ($user_role == 1) { $user_role = 2; } 

		    $result["status"] = 'ok';   $result["user_role"] = $user_role;  
		      
		    // check correct password  
                 
            if ( !empty( $user_password ) && Yii::$app->getSecurity()->validatePassword( $password, $user_password )) {
	                
	                $result["result"] = 'valid'; 
	                
	                if ( $user_role == 2 ) {  $user_role_title = 'staff'; }
	                if ( $user_role == 3 ) {  $user_role_title = 'relative'; }
	                if ( $user_role == 4 ) {  $user_role_title = 'patient'; }
	                
			$result["user_type"] = $user_role_title ;
		        $result["user_id"] = $user_id;
                        $result["authToken"] = $authToken =  md5(  $login . $password . date('Y-m-d H:i:s') ) ;
 
                      // save token to DB
                   Yii::$app->db->createCommand()
                            ->update('cl_users', ['authToken' => $authToken ], " login LIKE '". $login ."' "  )
                            ->execute();
					 (new \app\models\UserLog(['system'=>'app','user_id'=>$user_id,'method'=>'username_password','result'=>'login_success']))->saveLog();
                     } else {    $result["error_message"] = "Incorrect password" ;  
	                     		 $result["result"] = 'error';    
	        }
          
			
			 // if error login 	 
			} else {  $error = "Fill in required fields" ;      }
			 
			  
			 
		 //  ------------------------------ OUTPUT DATA ------------------------	 

if (!empty($error)) {
    (new \app\models\UserLog(['system'=>'app','user_id'=>@$user_id,'method'=>'username_password','result'=>'login_fail']))->saveLog();
   if ( $error ) {  $result["error"] = $error; 	Yii::$app->getResponse()->setStatusCode(401);  }
}

if (!empty($result)) {
    echo json_encode( $result, JSON_UNESCAPED_UNICODE );
}

?>
