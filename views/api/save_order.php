<?php

use app\models\Orders;
use app\models\OrderStatus;
use app\models\ProductItems;

error_reporting(0);

date_default_timezone_set('CET');

// ===================================================================================
// ========================= Save Patients Order
// ===================================================================================


$request = Yii::$app->request;

$authToken = $request->post('authToken');
$user_id = $request->post('user_id');
$patient_id = $request->post('patient_id');
$page_link = $request->post('page_link');
$order_title = $request->post('order_title');
$order_data = $request->post('order_data',[]);
$price = $request->post('price');
$currency = $request->post('currency');

$result["tmp"] = $order_data;


//  ------------------------------ Check Input Data ------------------------

if ($authToken && $user_id) {

    $res = (new \yii\db\Query())
        ->select(['*'])->from('cl_users')->where(['user_id' => $user_id, 'authToken' => $authToken, 'login_allowed' => 1])->all();
    foreach ($res as $row) {
        $login = $row['login'];
        $provider_id = $row['provider_id'];
    }

    if (!empty($login) && $provider_id > 0) {    // if valid security token
        $sort_id = 1;
        $result["status"] = 'ok';
        $product = \app\models\Products::findOne($page_link);
        // ------------------------------------------
        // Insert information about new Order
        $order = new Orders([
            'order_title' => $order_title,
            'user_id' => $user_id,
            'create_date' => date("Y-m-d H:i:s"),
            'price' => $price,
            'order_status' => '1',
            'product_id' => $page_link,
            'patient_id' => $patient_id,
            'product_module'=>$product->module,
        ]);
        $order->modifier = \app\models\User::findOne($user_id);
        $order->sub_user_id = $user_id;
        if ($order->save()) {
            $order_id = $order->order_id;

            (new OrderStatus([
                'order_id' => $order_id,
                'user_id' => $user_id,
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 1,
            ]))->save();
            $result["order_id"][] = $order_id;

            foreach ($order_data as $ord) {

                $order_data=null;
                $prod_item_id=null;
                $order_date_time = null;
                $order_choices = [];
                foreach ($ord as $key => $ord2) {

                    //$result["tmp_order"][] = $key.  "==>" . $ord2;

                    $key = str_replace('"', '', $key);
                    $ord2 = str_replace('"', '', $ord2);

                    if ($key == 'item_id') {
                        $prod_item_id = $ord2;
                    }
                    if ($key == 'user_value') {
                        $order_data = $ord2;
                    }
                    if ($key == 'order_date_time') {
                        $order_date_time = $ord2;
                    }
                    if ($key == 'order_choices') {
                        $order_choices = $ord2;
                    }



                }

                   $productItem = new ProductItems();
                   if (isset($prod_item_id)) {
                       $productItem = ProductItems::find()->where(['prod_item_id' => $prod_item_id])->one();
                   }
                   if(count($order_choices) > 0){

                       foreach ( $order_choices as $oc){
                           $itemCh = \app\models\ProductItemsChoices::find()->where(['id' => $oc]);
                           if (isset($itemCh)) {
                              $oi = new \app\models\OrderItems(
                               [ 'order_id'=>$order_id,
                                   'prod_item_id'=>$prod_item_id,
                                   'price'=> $itemCh->price,
                                   'product_item_choice_id'=>$itemCh->id ,
                                   'title'=>$productItem->title,
                                   'sort_id'=>$sort_id++,
                                   'data_text'=>$itemCh->title
                               ]
                               );
                              $oi->modifier = \app\models\User::findOne($user_id);
                              $oi->save();
                           }
                       }
                   }else{
                       $oi = new \app\models\OrderItems(
                           [ 'order_id'=>$order_id,
                               'prod_item_id'=>$prod_item_id,
                               'price'=> $productItem->price,
                               'data_text'=>$order_data,
                               'data_datetime'=>isset($order_date_time)?date('Y-m-d H:i;s' , strtotime($order_date_time)) : null,
                               'title'=>$productItem->title,
                               'sort_id'=>$sort_id++
                           ]
                       );
                       $oi->modifier = \app\models\User::findOne($user_id);
                       $oi->save();
                   }
            };

            $order->trigger(Orders::EVENT_ORDER_CREATED);

        } else {
            //var_dump($order->getErrors());
            $error = $order->getErrors();
        }
    } else {
        $error = "Incorrect authToken or missed Provider";

    };
} else {
    $error = "Enter authToken";
}


//  ------------------------------ OUTPUT DATA ------------------------

if (!empty($error)) {
    $logger = Yii::getLogger();
    $logger->log("save_order POST is responce  : ".json_encode($request->post()),1);
    $logger->log("save_order errors  : ".json_encode($error),1);
    if ($error) {
        $result["error"] = $error;
        Yii::$app->getResponse()->setStatusCode(401);
    }
}

if (!empty($result)) {
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}


?>