<?php

namespace app\controllers;

use app\models\Orders;
use app\models\OrdersSearch;
use app\models\OrderStatus;
use app\models\Providers;
use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
{


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['index','new_orders','in_progress','index2','report','ajax_report',
                            'ajax_missing_report','missing_orders','update-status','view','update','delete'],
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
     * Lists all SERVICE Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Orders([
            'isFoodOrder' => false,
        ]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $_SESSION['breadcrumbs'] = ['label'=>Yii::t('app','Orders - Service : History'),'url'=>['orders/index']];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title'=>'Orders - Service : History',
        ]);
    }

    /**
     * Lists all SERVICE Orders models.
     * @return mixed
     */
    public function actionNew_orders()
    {
        $searchModel = new Orders([
            'isFoodOrder' => false,
        ]);

        $dataProvider = $searchModel->searchNew(Yii::$app->request->queryParams);
        $model = new Orders([
            'isFoodOrder' => false,
        ]);
        $dataProviderNew = $model->searchNew(Yii::$app->request->queryParams);
        $_SESSION['breadcrumbs'] = ['label'=>Yii::t('app','Orders - Service : New Orders '),'url'=>['orders/new_orders']];

        return $this->render('new_orders', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProviderNew'=>$dataProviderNew
        ]);
    }

    /**
     * Lists all SERVICE Orders models.
     * @return mixed
     */
    public function actionIn_progress()
    {
        $searchModel = new Orders([
            'isFoodOrder' => false,
        ]);
        $searchModel->order_status = 3;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $_SESSION['breadcrumbs'] = ['label'=>Yii::t('app','Orders - Service : In Progress'),'url'=>['orders/in_progress']];

        return $this->render('in_progress', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all FOOD Orders models.
     * @return mixed
     */
    public function actionIndex2()
    {
        $searchModel = new Orders([
            'isFoodOrder' => true,
        ]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $_SESSION['breadcrumbs'] = ['label'=>Yii::t('app','Orders - Food : History'),'url'=>['orders/index2']];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title'=>'Orders - Food : History',
        ]);
    }

    public function actionReport(){
        return $this->render('report');
    }

    public function actionAjax_report(){
        if(isset($_POST['menu']))
        return $this->renderPartial('_report',['prod_id' => $_POST['menu']]);
        return "";

    }

    public function actionAjax_missing_report(){
        if(isset($_POST['menu']))
            return $this->renderPartial('_missing',['prod_id' => $_POST['menu']]);
        return "";

    }
    public function actionMissing_orders(){
        return $this->render('missing_orders');
    }

    public function actionMissingFoodOrder()
    {
        $query = User::find()
            ->andWhere([User::tableName().'.user_role' => 4]) // Patient
            ->leftJoin(Orders::tableName(), User::tableName().'.user_id='.Orders::tableName().'.user_id AND '.Orders::tableName()/*.'.product_type=\'food_menu\''*/)
            ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Providers::getNumUiItems(),
            ],
        ]);

        return $this->render('missing_food_order', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
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
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orders([
            'order_status' => 1, // created
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {


            (new OrderStatus([
                'order_id' => $model->order_id,
                'user_id' => Yii::$app->user->id,
                'created_at' => date('Y-m-d H:i:s'),
                'status' => $model->order_status,
            ]))->save();

            return $this->redirect(['view', 'id' => $model->order_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
     public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			
			$provider_id =  Yii::$app->user->identity->provider_id; 
			$user_id =  Yii::$app->user->identity->user_id; 
			$order_status = $model->order_status; 
			$this->save_log_order_status( $model->order_id, $order_status, $user_id, $provider_id );
			 
			
            return $this->redirect(['view', 'id' => $model->order_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdateStatus($id, $status)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = $this->findModel($id);
        $model->updateStatus($status);
        //return ['status' => 'error'];
        return $this->redirect(['view', 'id' => $model->order_id]);
    }
    
    
     public function save_log_order_status( $order_id, $order_status, $user_id, $provider_id )
    {
	   $res = Yii::$app->db->createCommand()->insert('cl_' .$provider_id. '_logs', [ 
							'action_type' => 1, 'created_by' => $user_id,  'created_time' =>  date("Y-m-d H:i:s") , 
							'details' => "Change status. Order ID: " . $user_id. ', new status: '. $order_status
							])->execute(); 
	   
	}  
	
	
	

    /**
     * Deletes an existing Orders model.
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
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
