<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                        'actions' => ['index','update','delete','view','save-relations','groups'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['admin','super_admin']
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

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new User();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User(); 

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	        
	        
	        $image_name = SiteController::actionUploadImage(  400, 400, 'users', 'photo', $model,$model->user_id   ); // upload image function
	        if( $image_name  == '' ) {
	            $request = Yii::$app->request;
	            $image_name =  $request->post('old_image');
	        }
            if( $image_name  == '' ) {
                $image_name = 'def_img.png';
            }
	         
	        if( $image_name != '' ) { 
	         Yii::$app->db->createCommand()
					        ->update('cl_users', ['photo' => $image_name ], ' user_id = ' . $model->user_id  )
					 		->execute();
			}		 		
	         
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->login_bankid = true;
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id); 

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	         
	        $image_name = SiteController::actionUploadImage(  400, 400, 'users', 'photo', $model , $model->user_id  ); // upload image function
	        if( $image_name  == '' ) {   $request = Yii::$app->request; $image_name =  $request->post('old_image');  } 
	           
	        Yii::$app->db->createCommand()
					        ->update('cl_users', ['photo' => $image_name ], ' user_id = ' . $model->user_id  )
					 		->execute();
			 		  
	        $this->actionSaveRelations( $model->user_id   ); // save relation list
	         
	        // clear binding for some roles 
	        if( 0 ) {
		        
		        Yii::$app->db->createCommand()->delete('cl_group_members', [ 'user_id'  => $model->user_id  , 'group_type'  => 'group' ])->execute();
		        Yii::$app->db->createCommand()->delete('cl_group_members', [ 'user_id'  => $model->user_id  , 'group_type'  => 'patient' ])->execute();
 		        
			}
	         
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model 
            ]);
        }
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
     
    
    public function getPhoto( $user_id ) {  
   
	   $output  = ''; 
	   $sql =  "SELECT * FROM  cl_users WHERE user_id = '". $user_id ."'  ";
	   $res = Yii::$app->db->createCommand( $sql )->queryAll();
	   foreach ( $res as $row ) { 	  $output  = $row['photo'];     }
	    
	   return $output; 
	} 

    // ----------------------------- SAVE RELATIONS  ---------------------------------
    
    
   public function actionSaveRelations( $user_id )
    {   
    		
	        $request = Yii::$app->request; $relations_list =  $request->post('relations_list'); 
	        
	        $group_list =  $request->post('group_id'); 
	        
	        
		    Yii::$app->db->createCommand()->delete('cl_group_members', [ 'user_id'  => $user_id, 'group_type'  => 'patient' ])->execute();
	    	
	    	if ( $relations_list ) {
		    	 	 
	    		foreach ( $relations_list as $key => $val ) { 
		    	 
		    	 	if( $val > 0 ) { 
		    	 	  Yii::$app->db->createCommand()->insert('cl_group_members', [
						    'user_id' => $user_id , 'parent_id' => $val, 'group_type'  => 'patient' 
						  ])->execute();   
						
						}  
	    			}
			} // end - relations_list

        Yii::$app->db->createCommand()->delete('cl_group_members', [ 'user_id'  => $user_id, 'group_type'  => 'group' ])->execute();

	    	if ( $group_list ) {
		        
                 foreach ( $group_list as $key => $val ) {
		    	 
		    	 	if( $val > 0 ) { 
		    	 	  Yii::$app->db->createCommand()->insert('cl_group_members', [
						    'user_id' => $user_id , 'group_id' => $val,  'parent_id' => '0', 'group_type'  => 'group' 
						  ])->execute();   
						
						}  
	    			}
			} // end - relations_list
    }
    
    
    
   // -----------------------------  LOAD USER GROUPS  ---------------------------------
     
    
    public function actionGroups()
    {   
	    $user_id =  Yii::$app->user->identity->user_id;	
	    $provider_id =  Yii::$app->user->identity->provider_id;  
	     
	    $request = Yii::$app->request; $new_group_name =  $request->post('new_group_name');  
	    $delete_id =  $request->get('dg');
	    $edit_group =  $request->post('edit_group');
	    
	    //--------------------- Action Create Group: 
	    
	    if ( $new_group_name ) { 
		     
		     $sql =  " INSERT INTO `cl_groups` (`group_id`, `name`, `provider_id`) VALUES (NULL, '". $new_group_name ."', '".$provider_id."');  ";
			 $res = Yii::$app->db->createCommand( $sql )->execute();
			 
			 $group_id = Yii::$app->db->getLastInsertID();
			 
			 /* $sql =  " INSERT INTO `cl_group_members` (`group_id`, `user_id`) VALUES ( '".$group_id."', '". $user_id ."');  ";
			 $res = Yii::$app->db->createCommand( $sql )->execute(); */
			 
			  Yii::$app->getResponse()->redirect('/user/groups');
	    } 
	    
	    
	    //--------------------- Action Delete Group: 
	     
	    if ( $delete_id ) {  
		    
		     $sql =  " SELECT * from `cl_groups` WHERE provider_id = '".$provider_id."' AND group_id = '". $delete_id ."'  ";
			 $res = Yii::$app->db->createCommand( $sql )->queryAll();
			 foreach ( $res as $row ) {  $group_access = $row["group_id"];  }
		     
		     if ( $group_access  > 0 ) {
			     
			     $sql =  "  DELETE FROM `cl_groups` WHERE provider_id = '".$provider_id."' AND group_id = '".$delete_id."' ";
				 $res = Yii::$app->db->createCommand( $sql )->execute();
				 
				 $sql =  " DELETE FROM  `cl_group_members` WHERE group_id = '".$delete_id."'  ";
				 $res = Yii::$app->db->createCommand( $sql )->execute();
				  
				 Yii::$app->getResponse()->redirect('/user/groups');
			 
			 }
			 
		} // end delete group
		
		 //--------------------- Action Edit Group: 
	     
	    if ( $edit_group ) {  
		    
		    $sql =  " SELECT * from `cl_groups` WHERE provider_id = '". $provider_id ."' AND group_id = '". $edit_group ."'  ";
			$res = Yii::$app->db->createCommand( $sql )->queryAll();
			foreach ( $res as $row ) {  $group_access = $row["group_id"];  }
		     
		    if ( $group_access  > 0 ) {
			     
			     $group_name = $request->post('group_name'); 
			     $group_users = $request->post('group_users'); //echo '<pre>'; var_dump( $group_users ); die();
			     
			     $sql =  " UPDATE  `cl_groups` SET  `name` =  '". $group_name ."' WHERE  group_id = '".$edit_group."' ";
				 $res = Yii::$app->db->createCommand( $sql )->execute();
				 
				 if( $group_users ) { 
				 
					$sql =  "  DELETE FROM `cl_group_members` WHERE group_id = '".$edit_group."' AND  `group_type` = 'group'  ";
					$res = Yii::$app->db->createCommand( $sql )->execute(); 
					 
					foreach ( $group_users as $member ) {   
						  
						  $sql =  " INSERT INTO `cl_group_members` (`group_id`, `user_id`, `group_type` ) VALUES ( '". $edit_group ."', '".$member."',  'group' );  ";
						  $res = Yii::$app->db->createCommand( $sql )->execute();
					}
				 }
				 
				 Yii::$app->getResponse()->redirect('/user/groups');
		     }
		        
	    } // end update group 
	    
        return $this->render('groups', [   ]);
    }

      
}
