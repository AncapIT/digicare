<?php

namespace app\controllers;

use app\components\DigiCareHelper;
use app\models\Documents;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DocumentsController implements the CRUD actions for Documents model.
 */
class DocumentsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
     * Lists all Documents models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Documents();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if(isset($_GET['Documents']['doc_type'])){
            switch ($_GET['Documents']['doc_type']){
                case 'about_patient':
                    $_SESSION['breadcrumbs'] = ['label'=>Yii::t('app','Documents : About Patient'),'url'=>['documents/index','Documents[doc_type]'=>'about_patient']];
                    break;
                case 'implementation':
                    $_SESSION['breadcrumbs'] = ['label'=>Yii::t('app','Documents : Implementation'),'url'=>['documents/index','Documents[doc_type]'=>'implementation']];
                    break;
                case 'diary':
                    $_SESSION['breadcrumbs'] = ['label'=>Yii::t('app','Documents : Diary'),'url'=>['documents/index','Documents[doc_type]'=>'diary']];
                    break;
                case 'billboard':
                    $_SESSION['breadcrumbs'] = ['label'=>Yii::t('app','Documents : Billboard'),'url'=>['documents/index','Documents[doc_type]'=>'billboard']];
                    break;
                case 'calendar':
                    $_SESSION['breadcrumbs'] = ['label'=>Yii::t('app','Documents : Calendar'),'url'=>['documents/index','Documents[doc_type]'=>'calendar']];
                    break;
                case 'newsletter':
                    $_SESSION['breadcrumbs'] = ['label'=>Yii::t('app','Documents : Newsletter'),'url'=>['documents/index','Documents[doc_type]'=>'newsletter']];
                    break;

            }
        }else{
            $_SESSION['breadcrumbs'] = ['label'=>Yii::t('app','Documents List'),'url'=>['documents/index']];

        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Documents model.
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
     * Creates a new Documents model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        //SEnd notification to user that new document is created
        $docType = isset($_POST["Documents"]["doc_type"]) ? $_POST["Documents"]["doc_type"] : '';
        if(!empty($docType))
        {
            //If newsletter, send notification to everyone
            if($docType == 'newsletter')
            {
                $content = [
                    'en' => 'Newsletter: ' . (isset($_POST["Documents"]["doc_title"]) ? $_POST["Documents"]["doc_title"] : '')
                ];
                $headings = [
                    'en' => (isset($_POST["Documents"]["doc_content"]) ? substr($_POST["Documents"]["doc_content"], 0, 25) : 'New Newsletter from Digicare')
                ];
                $includedSegments = ['All'];
                $body = (isset($_POST["Documents"]["doc_content"]) ? substr($_POST["Documents"]["doc_content"], 0, 25) : 'New Newsletter from Digicare');
                $data = ['type' => 'newsletter', 'value' => 'newsletter', 'body' => $body, 'status' => '200'];
                DigiCareHelper::sendNotification($content, $headings, $data, $includedSegments, [], false);
            }
            if($docType == 'billboard')
            {
                //If billboard, send notification to everyone
                $content = [
                    'en' => 'Billboard: ' . (isset($_POST["Documents"]["doc_title"]) ? $_POST["Documents"]["doc_title"] : '')
                ];
                $headings = [
                    'en' => (isset($_POST["Documents"]["doc_content"]) ? substr($_POST["Documents"]["doc_content"], 0, 25) : 'New Billboard from Digicare')
                ];
                $includedSegments = ['All'];
                $body = (isset($_POST["Documents"]["doc_content"]) ? substr($_POST["Documents"]["doc_content"], 0, 25) : 'New Billboard from Digicare');
                $data = ['type' => 'billboard', 'value' => 'billboard', 'body' => $body, 'status' => '200'];
                DigiCareHelper::sendNotification($content, $headings, $data, $includedSegments, [], false);
            }
        }

        $model = new Documents();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	        
	        $image_name = SiteController::actionUploadImage( 400, 400, 'news', 'doc_image', $model,  $model->doc_id   ); // upload image function
	        
	        $request = Yii::$app->request; $pid =  $request->get('pid'); if( !$pid ) { $pid = 1;  } 
	        if( $image_name  == '' ) {   $request = Yii::$app->request; $image_name =  $request->post('old_image');  } 
	         
	        Yii::$app->db->createCommand()
					        ->update('cl_'. $pid .'_documents', ['doc_image' => $image_name ], ' doc_id = ' . $model->doc_id  )
					 		->execute();
	        
            return $this->redirect(['view', 'id' => $model->doc_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Documents model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	        
	        $image_name = SiteController::actionUploadImage( 400, 400, 'news', 'doc_image', $model , $model->doc_id   ); // upload image function
	        
	        $request = Yii::$app->request; $pid =  $request->get('pid'); if( !$pid ) { $pid = 1;  } 
	        if( $image_name  == '' ) {   $request = Yii::$app->request; $image_name =  $request->post('old_image');  } 
	         
	        Yii::$app->db->createCommand()
					        ->update('cl_'. $pid .'_documents', ['doc_image' => $image_name ], ' doc_id = ' . $model->doc_id  )
					 		->execute();
	        
            return $this->redirect(['view', 'id' => $model->doc_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Documents model.
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
     * Finds the Documents model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Documents the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Documents::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    
    
    
    
}