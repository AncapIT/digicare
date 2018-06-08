<?php use yii\helpers\Url;

error_reporting(0);


$apiKey = "8356e98c6551b448f4fa6ea2f0b2f54b";
$authenticateServiceKey = "7658bea0424291f017211348606613c4";
$endpoint = 'https://client-test.grandid.com/json1.1/';
$callbackUrl = Url::to(['/site/login-bank-id'], true);

if(!isset($_GET['grandidsession'])) {
    $url = $endpoint . "FederatedLogin?authenticateServiceKey=".
        $authenticateServiceKey."&apiKey=".$apiKey."&callbackUrl=".$callbackUrl;
    $result = trim(file_get_contents($url));

    echo $result;
} else {
//    $response = file_get_contents($endpoint."GetSession?authenticateServiceKey=".
//        $authenticateServiceKey."&apiKey=".$apiKey."&sessionid=".$_GET['grandidsession']);
//
//    $result = json_decode($response,1);
//    if (!empty($result['username'])) {
//        $user = User::find()->andWhere(['bankid' => $result['username']])->one();
//        if ($user) {
//            Yii::$app->user->login($user);
//        }
//    }

}
 
  
			   
        
?>
