<?php

namespace app\controllers;

use app\components\DigiCareHelper;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','index'],
                'rules' => [
                    [
                        'actions' => ['logout','index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) ) {
            $user = $model->getUser();

            if( isset($user) && $user->login_allowed == 1 && $model->login && $model->login()){
                (new \app\models\UserLog(['system'=>'adminui','user_id'=>Yii::$app->user->identity->user_id,'method'=>'username_password','result'=>'login_success']))->saveLog();
                return $this->goBack();
            }else{

                if(isset($user)){
                    (new \app\models\UserLog(['system'=>'adminui','user_id'=>$user->user_id,'method'=>'username_password','result'=>'login_fail']))->saveLog();

                }
            }
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        (new \app\models\UserLog(['system'=>'adminui','user_id'=>Yii::$app->user->identity->user_id,'method'=>'','result'=>'logout']))->saveLog();
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionLoginBankId()
    {
        $apiKey = Yii::$app->params["BankID_apiKey"];
        $authenticateServiceKey = Yii::$app->params["BankID_authenticateServiceKey"];
        $endpoint = 'https://client-test.grandid.com/json1.1/';
        $callbackUrl = Url::to(['/site/login-bank-id'], true);

        if(!isset($_GET['grandidsession'])) {
            $url = $endpoint . "FederatedLogin?authenticateServiceKey=".
                $authenticateServiceKey."&apiKey=".$apiKey."&callbackUrl=".$callbackUrl;
            $result = json_decode(trim(file_get_contents($url)),1);

            return $this->redirect($result['redirectUrl']);
        } else {
            $response = file_get_contents($endpoint."GetSession?authenticateServiceKey=".
                $authenticateServiceKey."&apiKey=".$apiKey."&sessionid=".$_GET['grandidsession']);

            $result = json_decode($response,1);
            if (!empty($result['username'])) {
                $user = User::find()->andWhere([
                    'login' => $result['username'],
                    'login_bankid' => '1',
                    'login_allowed' => 1
                ])->one();
                if ($user) {
                    Yii::$app->user->login($user);
                    (new \app\models\UserLog(['system'=>'adminui','user_id'=>$user->user_id,'method'=>'bankid','result'=>'login_success']))->saveLog();
                    return $this->goBack();
                }else{
                    (new \app\models\UserLog(['system'=>'adminui','user_id'=>isset($user->user_id)? $user->user_id : 0 ,'method'=>'bankid','result'=>'login_fail']))->saveLog();
                }

            }
            return $this->goHome();
        }

    }
    
    
    
      // ----------------------------- UPLOAD IMAGE ---------------------------------
    
    
     public static function actionUploadImage( $width, $height, $folder, $imagefield, $model, $id = ""  )
    {   
	          
	        $uploadPath = Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/' ;

	        $image = \yii\web\UploadedFile::getInstance($model, $imagefield  );  // var_dump($image);  die();
	        
	        if( $image ) { 
		        
	            // store the source file name
	            $img_name = $image->name;
	            $ext = $image->extension;


	           
	            // generate a unique file name
	            $new_name  = $id.'-'.$img_name;
	            $orig_name = $id.'-original-'.$img_name;
	            $path = $uploadPath. $folder . '/'  ;
	             
	            $image->saveAs($path. $new_name); //  echo "-->" . $path; die();


                //crop if dimentions are set
                if($width && $height){
                    copy($path. $new_name,$path. $orig_name);
                    DigiCareHelper::resizeImage($width,$height,$path. $new_name);
                }

                return  $new_name;
	             
            }
        		
	} // -------------- END - upload image --------------------
	
	
	 
	 
    
}
