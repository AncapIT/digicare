<?php use app\models\OrderStatus;

error_reporting(0);
date_default_timezone_set('CET');

require_once(__DIR__ . '/stripe/init.php');

// ===================================================================================
// ========================= Stripe Payment Operations
// ===================================================================================


$request = Yii::$app->request;

$authToken = $request->post('authToken');
$user_id = $request->post('user_id');

$token = $request->post('token');
$amount = $request->post('amount');
$currency = $request->post('currency');
if (!$currency) {
    $currency = 'sek';
}
$description = $request->post('description');
$action = $request->post('action');
$order_id = $request->post('order_id');

//  ------------------------------ Check Input Data ------------------------

if ($authToken && $user_id) {

    $row = (new \yii\db\Query())
        ->select(['*'])->from('cl_users')->where(['user_id' => $user_id, 'authToken' => $authToken, 'login_allowed' => 1])->one();

    $login = $row['login'];
    $provider_id = intval($row['provider_id']);
    $user_name = $row["first_name"] . ' ' . $row["last_name"];
    $user_email = $row["email"];


    if (!empty($login)) {    // if valid security token

        $result["status"] = 'ok';


        if ($action == 'create_charge') {

            // ------------------------- TRY STRIPE CARD PAYMENT
            try {
                $curl = new \Stripe\HttpClient\CurlClient(array(CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1));
                \Stripe\ApiRequestor::setHttpClient($curl);
                \Stripe\Stripe::setApiKey("sk_test_0bjRgxdd0GXdphbqIIJ7dkzW");

                // create payment transaction
                try {

                    $ch_params = array(
                        "amount" => $amount * 100, // сумма в центах
                        "currency" => $currency,
                        "source" => $token,
                        "description" => $description,
                        "metadata" => array("provider_id" => $provider_id,
                            "order_id" => $order_id)
                    );
                    if(isset($user_email) && $user_email != '' && strpos($user_email,'@')>0){
                        $ch_params[] = ["receipt_email" => $user_email];
                    }
                    $charge = \Stripe\Charge::create($ch_params);

                    //$result["payment_result"] = $charge;

                    if ($charge["paid"] == true || $charge["paid"] == 1) {

                        $result["payment_result"] = "ok";
                        $result["transaction_id"] = $payment_ref = $charge["id"];
                        $result["card_token"] = $card_token = $charge["source"]["id"];

                        // update current order status
                        update_order($provider_id, $order_id, '2', $payment_ref,$user_id); // 2 - Paid

                        // Save user card data token
                        save_card_token($provider_id, $user_id, $card_token);
                    }


                } catch (\Stripe\Error\Card $e) { // error message

                    $result["payment_result"] = "error";
                }


            } catch (Exception $e) {
                $result["payment_result"] = "errors: " . $e->getMessage();
                //exit;
            }
            // ------------- END

        }


    } else {
        $error = "Incorrect authToken";
    }

} else {
    $error = "Missed authToken";
}


// ===================================================================================
// ========================= update_order after success payment
// ===================================================================================


function update_order($provider_id, $order_id, $status, $payment_ref,$user_id)
{

    $sql = " UPDATE cl_" . $provider_id . "_orders SET payment_ref = '" . $payment_ref . "', order_status = '" . $status . "',  update_date = '" . date("Y-m-d H:i:s") . "'   WHERE order_id = '" . $order_id . "'  ";
    $res = Yii::$app->db->createCommand($sql)->execute();
    (new OrderStatus([
        'order_id' => $order_id,
        'user_id' => $user_id,
        'created_at' => date('Y-m-d H:i:s'),
        'status' => $status,
    ]))->save();
}


// ===================================================================================
// ========================= Save user card data token after success payment
// ===================================================================================


function save_card_token($provider_id, $user_id, $card_token)
{


}


//  ------------------------------ OUTPUT DATA ------------------------

if (!empty($error)) {
    if ($error) {
        $result["error"] = $error;    // Yii::$app->getResponse()->setStatusCode(401);
    }
}

if (!empty($result)) {
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}

//echo '<pre>' . $charge ;


?>