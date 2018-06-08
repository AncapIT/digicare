<?php

namespace app\controllers;

use app\models\Modules;
use app\models\Orders;
use app\models\User;
use Yii;
use yii\web\Controller;

/**
 * UserController implements the CRUD actions for User model.
 */
class ApiController extends Controller
{
    /**
     * @inheritdoc
     */
  public $enableCsrfValidation = false;
      
  public static function allowedDomains()
		{
		    return [
		        '*'
		    ];
		}
		
		/**
		 * @inheritdoc
		 */
		public function behaviors()
		{
		    return array_merge(parent::behaviors(), [
		
		        // For cross-domain AJAX request
		        'corsFilter'  => [
		            'class' => \yii\filters\Cors::className(),
		            'cors'  => [
		                // restrict access to domains:
		                'Origin'                           => ['*'],
		                'Access-Control-Request-Method'    => ['GET', 'POST', 'PUT', 'PATCH', 'HEAD', 'OPTIONS'],
		                //'Access-Control-Allow-Credentials' => true,
		                'Access-Control-Max-Age'           => 3600,                 // Cache (seconds)
		            ],
		        ],
		
		    ]);
		}
		

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
         return $this->render('index');
    }
 
    public function actionLogin()
    {	  
   		 return $this->renderAjax('login');
    }

    public function actionLogin_bankid()
    {
   		 return $this->renderAjax('login_bank_id');
    }
      
     public function actionGet_patients_list()
    {	  
   		 return $this->renderAjax('get_patients_list');
    }
          
    public function actionGet_personal_push_list()
    {	  
   		 return $this->renderAjax('get_personal_push_list');
    }
    
    public function actionGet_provider_info()
    {	  
   		 return $this->renderAjax('get_provider_info');
    } 
    
     public function actionGet_pages()
    {	  
   		 return $this->renderAjax('get_pages');
    }  
    
    public function actionGet_homepage_items()
    {	  
   		 return $this->renderAjax('get_homepage_items');
    }
    
    public function actionGet_documents()
    {	  
   		return $this->renderAjax('get_documents');
    }   
    
    public function actionGet_products_list()
    {	  
   		return $this->renderAjax('get_products_list');
    } 
    
     public function actionGet_product()
    {	  
   		 return $this->renderAjax('get_product');
    } 
     public function actionSave_order()
    {	  
   		 return $this->renderAjax('save_order');
    } 
 
	 public function actionGet_orders_history()
    {	  
   		return $this->renderAjax('get_orders_history');
    }
    
    public function actionGet_food_menu()
    {	  
   		return $this->renderAjax('get_food_menu');
    }
    
    public function actionLoad_patient()
    {	  
   		return $this->renderAjax('load_patient');
    } 
    
    public function actionUpdate_profile()
    {	  
   		return $this->renderAjax('update_profile');
    }
    public function actionGet_chat()
    {	  
   		return $this->renderAjax('get_chat');
    } 
    public function actionSend_chat()
    {	  
   		return $this->renderAjax('send_chat');
    }  
    public function actionUpload_image()
    {	  
   		return $this->renderAjax('upload_image');
    } 
     public function actionCheck_app_version()
    {	  
   		return $this->renderAjax('check_app_version');
    }  
	public function actionLoad_user()
    {	  
   		return $this->renderAjax('load_user');
    } 
    public function actionStripe_payment()
    {	  
   		return $this->renderAjax('stripe_payment');
    }

    public function actionCancel_order(){
       $id =  Yii::$app->request->post('order_id');
       $order = Orders::findOne($id);
       if(isset($order)){
           $order->updateStatus(5);
           $result["status"] = 'ok';
       }else{
           $result["error"] = 'order not found.';
       }
        echo json_encode( $result, JSON_UNESCAPED_UNICODE );
    }
    /**
     * API call,
     * request params $_GET['personNum']
     * response redirectURL and sessionID
     */
    public function actionGet_redirect_url(){
        if(isset($_POST["personNumber"])){

                $url = Yii::$app->params["BankID_endpoint"] . "FederatedLogin?authenticateServiceKey=".
                    Yii::$app->params["BankID_app_ServiceKey"]."&apiKey=". Yii::$app->params["BankID_apiKey"]."&pnr=".$_POST["personNumber"];
                $result = trim(file_get_contents($url));
                $result = str_replace("redirect=null","redirect=digicare://",$result);
                $logger = Yii::getLogger();
                $logger->log("bankId response  : ".$result,1);
                return $result;

        }else{
            return json_encode([
                "result"=>"error",
                "error_message"=>'Required parameter personNumber is missed'
            ]);

        }
    }

    /**
     * API call,
     * request params $_GET[' personNumber'] and $_GET['sessionId']
     * response redirectURL and sessionID
     */
    public function actionLogin_bank_id()
    {
        sleep(5);
        $api_result = array();
        $api_result["result"] = 'error';
        $logger = Yii::getLogger();

        $logger->log("POST sessid : /".$_POST["sessionId"]."/",1);
        if (isset($_POST["personNumber"]) && isset($_POST["sessionId"])) {
            $response = file_get_contents(Yii::$app->params["BankID_endpoint"]. "GetSession?apiKey=" . Yii::$app->params["BankID_apiKey"] . "&authenticateServiceKey=" .
                Yii::$app->params["BankID_app_ServiceKey"]  . "&sessionid=" . $_POST["sessionId"]);

            $result = json_decode($response, 1);
            $logger->log("BankId response: ".$response,1);
            if (!empty($result['username'])) {
                $user = User::find()->where([
                    'login' => $result['username'],
                    'login_bankid' => '1',
                    'login_allowed' => 1,
                ])->one();
                if (isset($user)) {
                    Yii::$app->user->login($user);
                    $api_result["result"] = 'valid';
                    (new \app\models\UserLog(['system'=>'app','user_id'=>$user->user_id,'method'=>'bankid','result'=>'login_success']))->saveLog();
		    // Temp fix to allow admin access to app - report users with role Admin as role Staff
                    if ($user->user_role == 1) { $user->user_role = 2; } 


                    $user_role_title = '';
                    if ( $user->user_role == 2 ) {  $user_role_title = 'staff'; }
                    if ( $user->user_role == 3 ) {  $user_role_title = 'relative'; }
                    if ( $user->user_role == 4 ) {  $user_role_title = 'patient'; }

                    $api_result["user_type"] = $user_role_title ;
                    $api_result["user_id"] = $user->user_id;
                    $api_result["authToken"] = $_POST["sessionId"] ;

                    // save token to DB
                    Yii::$app->db->createCommand()
                        ->update('cl_users', ['authToken' => $_POST["sessionId"] ], " login LIKE '". $user->login ."' "  )
                        ->execute();
                    $logger->log("BankId Success ",1);

                }else{
                    $api_result["result"] = 'error';
                    $api_result["error_message"]='user '.$result['username'].' not found <br> responce: '.$response;
                }

            }else{
                $api_result["result"] = 'error';
                $api_result["error_message"]='person: '.$_POST["personNumber"] ." <br> session: ".$_POST["sessionId"]. " <br> responce: ".$response;
            }
        }else{
            $api_result["result"] = 'error';
            $api_result["error_message"]='required parameter is missed! '. isset($_POST["personNumber"])? "personNumber":' ' . isset($_POST["sessionId"])? "sessionId": " ";
        }
        return json_encode($api_result);
    }

    public function actionCheck_if_can_order(){
        $order=new Orders();
        $order->user_id = Yii::$app->request->post('user_id');
        $order->product_id = Yii::$app->request->post('product_id');
        $order->patient_id = Yii::$app->request->post('patient_id');
        $result["status"] = 'ok';
        $result["can_order"] = $order->ifUserCanOrderMenu();
        return json_encode($result);
    }

    public function actionGet_user_modules(){

        $userId = Yii::$app->request->post('user_id');
        if(isset($userId)){
            $result["status"] = 'ok';
            $result['modules'] = Modules::getModulesForUser($userId);
        }else{
            $result['error']='user not found';
        }
        return json_encode($result);
    }

    public function actionLog_log_out(){
        $id =  Yii::$app->request->get('user_id');
        (new \app\models\UserLog(['system'=>'adminui','user_id'=>$id,'method'=>'','result'=>'logout']))->saveLog();
        $result["status"] = 'ok';
        echo json_encode( $result, JSON_UNESCAPED_UNICODE );
    }
}
