<?php

namespace app\controllers;

use app\components\DigiCareHelper;
use Yii;
use app\models\Messages;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MessagesController implements the CRUD actions for Messages model.
 */
class MessagesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                //  'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['index','create','update','delete','view'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function init()
    {
        if(!isset($_SESSION)){
            session_start();
        }
        parent::init(); // TODO: Change the autogenerated stub
    }

    /**
     * Lists all Messages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Messages();
        if(isset($_GET['view']) && $_GET['view'] == 'new'){
            $_SESSION['breadcrumbs'] = ['label'=>Yii::t('app','Messages: New Messages'),'url'=>['messages/index','view'=>'new']];
        }else{
            $_SESSION['breadcrumbs'] = ['label'=>Yii::t('app','Messages: Messages History '),'url'=>['messages/index']];
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(isset($_GET['read_group']) && is_numeric($_GET['read_group']))
        {Messages::markChatAsRead($_GET['read_group']);}
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Messages model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),

        ]);
    }

    /**
     * Creates a new Messages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $group_id = $request->post('group_id');
        $saved_group_id = $request->post('saved_group_id');

        if ( $group_id ) {  $group_id = $group_id[0];  } else {  $group_id = $saved_group_id ; }
        $model = new Messages();
        $model->patient_id = $group_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	        
	         $chat_code = $request->get('chat') ;
	        

	           
	        $image_name = SiteController::actionUploadImage( 0, 0, 'chat', 'attachment', $model ,   $group_id  ); // upload image function
	         
	        Yii::$app->db->createCommand()
					        ->update('cl_messages', ['attachment' => $image_name, 'patient_id' => $group_id  ], ' id = ' . $model->id  )
					 		->execute();

	        //SEnd notification to patient
            $content = [
                'en' => (isset($_POST["Messages"]["message"]) ? $_POST["Messages"]["message"] : '')
            ];
            $headings = [
                'en' => 'New messsage'
            ];
            $includedSegments = ['All'];
            $daTags = array(
                array("field" => "tag", "key" => "user_id", "relation" => "=", "value" => $group_id),
            );
            $body = (isset($_POST["Messages"]["message"]) ? substr($_POST["Messages"]["message"], 0, 25) : 'New message');
            $data = ['type' => 'messages', 'value' => 'messages', 'body' => $body, 'status' => '200'];
            DigiCareHelper::sendNotification($content, $headings, $data, $includedSegments, $daTags, true);
            //End Notification
			  
            return $this->redirect('/messages/create?&chat_group=' . $group_id );   
            
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Messages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Deletes an existing Messages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Messages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Messages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Messages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    
  
	
}
