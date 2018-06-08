<?php   
	    unset( $error );
		$request = Yii::$app->request; 
		
		$login = $request->post('login');   $password = $request->post('password');   
		
		// if success 
		if ( $login &&  $password ) { 
			
			$res = (new \yii\db\Query())
		    ->select(['password'])->from('user')->where(['username' => 'admin'  ])->all(); 
		    foreach ( $res as $row ) {  $user_password =  $row['password'];   } 
		     
		    if ( $user_password == $password  ) {  $result["authToken"] =  md5(  $login . $password ) ;   } else {   $error = Yii::t('app',"Incorrect password") ;  }
			
			 // if error login 	 
			 } else {  $error = Yii::t('app',"Fill in required fields") ;      }
			 
			  
			 
		 //  ------------------------------ OUTPUT DATA ------------------------	 
		
		 if ( $error ) {  $result["error"] = $error; 	Yii::$app->getResponse()->setStatusCode(401);  }
		 
	     echo json_encode( $result, JSON_UNESCAPED_UNICODE ); 


        
?>