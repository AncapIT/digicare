<?php error_reporting(0);

use app\models\User;

// ===================================================================================
// ========================= Get chat messages from this user
// ===================================================================================

$users = new User;

$request = Yii::$app->request;

$authToken = $request->post('authToken');
$user_from = $request->post('user_from');
$user_to = $request->post('user_to');
$user_type = $request->post('user_type');
$last_message_id = $request->post('last_message_id');

//  ------------------------------ Check Input Data ------------------------

if ($authToken && $user_from) {

    $res = (new \yii\db\Query())
        ->select(['*'])->from('cl_users')->where(['user_id' => $user_from, 'authToken' => $authToken, 'login_allowed' => 1])->one();

    if (isset($res['login']) && !empty($res['login'])) {    // if valid security token

        $result["status"] = 'ok';
        $result["updated"] = 'n';
        $result["last_message_id"] = 0;
        $num = 0;
        // determine patient id
        $patient_id = $res['user_role'] == 4 ? $user_from : $user_to;
        // ------------------------------------------

        // ------------------------------------------
        // Check if we need to update the list

        $sql = " SELECT max(id) as id FROM `cl_messages` WHERE   patient_id = '" . $patient_id . "'   ORDER BY id DESC LIMIT 1 ";
        $res = Yii::$app->db->createCommand($sql)->queryAll();
        $check_last_id = $result["last_message_id"] = $res['id'];

        if (($check_last_id != $last_message_id) || $last_message_id == 0 || !$last_message_id) {
            $result["updated"] = 'y';


            // ------------------------------------------
            // Select message list

            $user_img_path = \Yii::$app->request->BaseUrl . '/web/uploads/user/';

            $sql = " SELECT * FROM `cl_messages` WHERE  patient_id = '" . $patient_id . "'  ORDER BY created ASC  ";
            $res = Yii::$app->db->createCommand($sql)->queryAll();
            foreach ($res as $row) {

                $user_data = $users->find()->where(['user_id' => $row['user_id']])->one();

                $user_type = 'user';
                if ($row['user_id'] != $user_from) {
                    $user_type = 'agent';
                }

                $result["messages"][$num]["id"] = $row['id'];
                $result["messages"][$num]["messageText"] = $row['message'];
                $result["messages"][$num]["attachment_url"] = $row['attachment'];
                $result["messages"][$num]["user_type"] = $user_type;
                $result["messages"][$num]["time"] = $row['created'];
                $result["messages"][$num]["user_photo"] = $user_data["photo"];
                $result["messages"][$num]["user_name"] = $user_data["first_name"] . " " . $user_data["last_name"];

                $num++;
            } // end - list

        }

    } else {
        $error = "Incorrect authToken";
    }

} else {
    $error = "Missed authToken";
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


?>