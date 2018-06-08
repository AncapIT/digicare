<?php use app\components\DigiCareHelper;

error_reporting(0);
date_default_timezone_set('CET');

// ===================================================================================
// ========================= Save message from user
// ===================================================================================

$request = Yii::$app->request;

$authToken = $request->post('authToken');
$user_id = $request->post('user_id');
$user_to = $request->post('user_to');
$text = $request->post('message');
$created = date("Y-m-d H:i:s");


$action = $request->post('action');

//  ------------------------------ Check Input Data ------------------------

if ($authToken && $user_id) {

    $res = (new \yii\db\Query())
        ->select(['*'])->from('cl_users')->where(['user_id' => $user_id, 'authToken' => $authToken, 'login_allowed' => 1])->one();

    if (isset($res['login']) && !empty($res['login'])) {    // if valid security token

        $result["status"] = 'ok';
        $filename = '';

        // determine patient id
        $patient_id = $res['user_role'] == 4 ? $user_id : $user_to;
        $result["group_id"] = $patient_id;

        // ------------------------------------------
        // Insert new message row

        if ($action == 'send_attachment') {

            $width = 0;
            $height = 0; // resize max size in pixels

            $target_path = Yii::$app->basePath . '/web/uploads/chat/';
            $filename = $_FILES['wpua-file']['name'];
            $uploadfile = $target_path . basename($_FILES['wpua-file']['name']);


            // --------------- try load and copy file --------------------------------

            if (move_uploaded_file($_FILES['wpua-file']['tmp_name'], $uploadfile)) {

                // -----------------  RESIZE IMAGE ------------------

                if($width && $height)
                    DigiCareHelper::resizeImage($width,$height,$uploadfile);

            }

            $result["updated"] = true;
            $message = ' ';
        }

        if ($patient_id > 0) {

            $message = new \app\models\Messages();
            $message->user_id = $user_id;
            $message->created = $created;
            $message->message = $text;
            $message->attachment = $filename;
            $message->patient_id = $patient_id;
            $message->modifier = \app\models\User::findOne($user_id);
            $message->save();
        }


       

    } else {
        $error = "Incorrect authToken";
    }

} else {
    $error = "Missed authToken";
}

//  ------------------------------ OUTPUT DATA ------------------------

if (!empty($error)) {
    //  if ( $error ) {  $result["error"] = $error; 	Yii::$app->getResponse()->setStatusCode(401);  }
}

if (!empty($result)) {

 //SEnd notification to patient
        $content = [
            'en' => (isset($text) ? $text : '')
        ];
        $headings = [
            'en' => 'New messsage'
        ];
        $includedSegments = ['All'];
        $daTags = array(
            array("field" => "tag", "key" => "user_id", "relation" => "=", "value" => $request->post('user_to')),
        );
        $body = (isset($text) ? substr($text, 0, 25) : 'New message');
        $data = ['field' => 'tag', 'type' => 'messages', 'value' => 'messages', 'body' => $body, 'status' => '200'];
        DigiCareHelper::sendNotification($content, $headings, $data, $includedSegments, $daTags, true);
        //End Notification
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}


?>