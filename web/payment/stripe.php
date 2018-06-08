<?php error_reporting(1);
	
require_once( __DIR__ . '/init.php'); 

 
try {
    $curl = new \Stripe\HttpClient\CurlClient(array(CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1));
    \Stripe\ApiRequestor::setHttpClient($curl);
    \Stripe\Stripe::setApiKey("sk_test_0bjRgxdd0GXdphbqIIJ7dkzW");

    $token =  'tok_1BwXd1Ke0w6EuP57aA63gxYQ' ;
    
       // Создаём оплату 
		 try {
		 
		  echo '<br>charge -->' .  $charge = \Stripe\Charge::create(array(
		    "amount" => 100, // сумма в центах 
		    "currency" => "usd",
		    "source" => $token,
		    "description" => "Example charge"
		    ));
		    
		} catch(\Stripe\Error\Card $e) {
		  // Платёж не прошёл
		  echo '<br>error -->  Платёж не прошёл ' ; 
		
		} 

 
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}  

/*   
// Устанавливаем секретный ключ 
\Stripe\Stripe::setApiKey("sk_test_0bjRgxdd0GXdphbqIIJ7dkzW");

// Забираем token 
echo '<br>token -->'. $token = $_REQUEST['token'];  // 'tok_1AS5JvA4zp3nz8Osok4hRQYe';  //
*/ 



?>