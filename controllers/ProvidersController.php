<?php

namespace app\controllers;

use app\models\Providers;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


/**
 * ProvidersController implements the CRUD actions for Providers model.
 */
class ProvidersController extends Controller
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
                        'actions' => ['update', 'view', 'delete', 'delete-provider'],
                        'allow' => true,
                        'roles' => ['admin'],

                    ],
                    [
                        'actions' => ['create', 'create-provider'],
                        'allow' => true,
                        'roles' => ['superAdmin'],
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


    public function actionIndex()
    {
        throw new NotFoundHttpException('The requested page does not exist.');
        /*    $searchModel = new Providers();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);*/
    }

    /**
     * Displays a single Providers model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (Yii::$app->user->identity->isAdmin()) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Providers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->identity->isSuperAdmin()) {
            $model = new Providers();
            $user = new User();
            $user->user_role = 1;
            $user->login_allowed = 1;
            if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post()) && $user->validate() && $model->save()) {

                $this->actionCreateProvider($model->provider_id); // Create additional tables

                $image_name = SiteController::actionUploadImage(0, 0, 'providers', 'provider_logo', $model, $model->provider_id); // upload image function
                if ($image_name == '') {
                    $request = Yii::$app->request;
                    $image_name = $request->post('old_image');
                }


                $image_name2 = SiteController::actionUploadImage(0, 0, 'providers', 'provider_menu_logo', $model, $model->provider_id); // upload image function
                if ($image_name2 == '') {
                    $request = Yii::$app->request;
                    $image_name2 = $request->post('old_image2');
                }


                Yii::$app->db->createCommand()
                    ->update('cl_providers', ['provider_logo' => $image_name, 'provider_menu_logo' => $image_name2], 'provider_id = ' . $model->provider_id)
                    ->execute();

                $request = Yii::$app->request;

                // save data for NEW binded admin user
                $user->provider_id = $model->provider_id;
                $user->new_password = $user->password;
                $user->save();

                return $this->redirect(['site/index']);
            } else {

                return $this->render('create', [
                    'model' => $model, 'user' => $user
                ]);
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }

    /**
     * Updates an existing Providers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->identity->isAdmin()) {
            $model = $this->findModel($id);

            $user_role = Yii::$app->user->identity->user_role;

            // ------ get admin_user data for binded admin account

            $users = new User();
            $user_data = $users->find()->where(['provider_id' => $id, 'user_role' => 1])->one();

            $admin_user = [];
            $admin_user["admin_first_name"] = $user_data["first_name"];
            $admin_user["admin_last_name"] = $user_data["last_name"];
            $admin_user["admin_email"] = $user_data["email"];
            $admin_user["admin_username"] = $user_data["login"];

            $admin_user_id = $user_data["user_id"];;

            // ------ Save this params after update

            if ($model->load(Yii::$app->request->post()) && $model->save()) {

                $image_name = SiteController::actionUploadImage(0, 0, 'providers', 'provider_logo', $model, $model->provider_id); // upload image function
                if ($image_name == '') {
                    $request = Yii::$app->request;
                    $image_name = $request->post('old_image');
                }


                $image_name2 = SiteController::actionUploadImage(0, 0, 'providers', 'provider_menu_logo', $model, $model->provider_id); // upload image function
                if ($image_name2 == '') {
                    $request = Yii::$app->request;
                    $image_name2 = $request->post('old_image2');
                }

                Yii::$app->db->createCommand()
                    ->update('cl_providers', ['provider_logo' => $image_name, 'provider_menu_logo' => $image_name2], 'provider_id = ' . $model->provider_id)
                    ->execute();

                return $this->redirect(['view', 'id' => $model->provider_id]);
            } else {
                return $this->render('update', [
                    'model' => $model, 'admin_user' => $admin_user
                ]);
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * Deletes an existing Providers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        throw new NotFoundHttpException('The requested page does not exist.');
        if (Yii::$app->user->identity->isSuperAdmin()) {
            $model = $this->findModel($id);

            $this->actionDeleteProvider($model->provider_id); // delete all tebles this provider

            $this->findModel($id)->delete();
        }


    }


    /**
     * Finds the Providers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Providers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Providers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    // ----------------------------- CREATE TABLES FOR NEW PROVIDER ---------------------------------


    public function actionCreateProvider($id)
    {

        $model = $this->findModel($id);

        $new_provider = $model->provider_id;

        $sql = ' CREATE TABLE IF NOT EXISTS `cl_' . $new_provider . '_documents` (
		  `doc_id` int(11) NOT NULL AUTO_INCREMENT,
		  `doc_title` varchar(500) NOT NULL,
		  `user_id` int(15) NOT NULL DEFAULT "0",
		  `category_desc` varchar(1) NOT NULL DEFAULT "n",
		  `doc_header` varchar(500) NOT NULL,
		  `doc_type` varchar(100) NOT NULL,
		  `doc_date` datetime DEFAULT NULL,
		  `doc_content` text NOT NULL,
		  `doc_options` varchar(500) NOT NULL,
		  `doc_image` varchar(100) NOT NULL,
		  `pdf_link` varchar(500) NOT NULL,
		  `published` int(1),
		  `created_at` datetime DEFAULT NULL,
		  `updated_at` datetime DEFAULT NULL,
		  `created_by` int(15) DEFAULT NULL,
		  `updated_by` int(15) DEFAULT NULL,
		  PRIMARY KEY (`doc_id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ; ';

        $res = Yii::$app->db->createCommand($sql)->execute();

        $sql = "  CREATE TABLE IF NOT EXISTS `cl_" . $new_provider . "_product_items` (
		  `prod_item_id` int(15) NOT NULL AUTO_INCREMENT,
		  `product_id` int(15) NOT NULL,
		  `sort_id` int(11) NOT NULL,
		  `product_item_type` varchar(255) NOT NULL,
		  `mandatory` varchar(1) NOT NULL DEFAULT 'n',
		  `title` varchar(150) NOT NULL,
		  `description` text NOT NULL,
		  `price` float DEFAULT '0',
		   `created_at` datetime DEFAULT NULL,
		  `updated_at` datetime DEFAULT NULL,
		  `created_by` int(15) DEFAULT NULL,
		  `updated_by` int(15) DEFAULT NULL,
		  PRIMARY KEY (`prod_item_id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58  ";

        $res = Yii::$app->db->createCommand($sql)->execute();

        $sql = " CREATE TABLE IF NOT EXISTS `cl_" . $new_provider . "_modules` ( 
		  `module_id` int(15) NOT NULL AUTO_INCREMENT,
		  `module_name` varchar(255) NOT NULL,
		  `sub_module` varchar(1) NOT NULL DEFAULT 'n',
		  `sort_order` int(10) NOT NULL,
		  `comment` varchar(500) NOT NULL,
		  `parent_page` varchar(155) NOT NULL,
		  `module_icon` varchar(255) NOT NULL,
		  `link` varchar(255) NOT NULL,
		  `status` varchar(1) NOT NULL DEFAULT 'y',
		  `module_role_id` varchar(255) NOT NULL DEFAULT '4',
		  `module_type` varchar(100) NOT NULL,
		   `created_at` datetime DEFAULT NULL,
		  `updated_at` datetime DEFAULT NULL,
		  `created_by` int(15) DEFAULT NULL,
		  `updated_by` int(15) DEFAULT NULL,
		  PRIMARY KEY (`module_id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ; ";

        $res = Yii::$app->db->createCommand($sql)->execute();

        $sql = " CREATE TABLE IF NOT EXISTS `cl_" . $new_provider . "_orders` (
		  `order_id` int(11) NOT NULL AUTO_INCREMENT,
		  `order_title` varchar(150) NOT NULL,
		  `user_id` int(11) NOT NULL,
	      `product_id` int(11),
		  `create_date` datetime NOT NULL,
		  `update_date` datetime NOT NULL,
		  `price` float NOT NULL,
		  `order_status` int(1) NOT NULL DEFAULT '0',
		  `payment_ref` varchar(255),
		  `patient_id` int(11),
		  `product_module` varchar(64),
		   `created_at` datetime DEFAULT NULL,
		  `updated_at` datetime DEFAULT NULL,
		  `created_by` int(15) DEFAULT NULL,
		  `updated_by` int(15) DEFAULT NULL,
		  PRIMARY KEY (`order_id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ";

        $res = Yii::$app->db->createCommand($sql)->execute();


        $sql = " CREATE TABLE IF NOT EXISTS `cl_" . $new_provider . "_order_items` (
		  `order_item_id` int(15) NOT NULL AUTO_INCREMENT,
		  `order_id` int(15) NOT NULL,
		  `prod_item_id` int(15) NOT NULL,
		  `data_text` varchar(500) NOT NULL,
		  `sort_id` int(15) NOT NULL,
		  `title` varchar(150) NOT NULL,
		  `data_datetime` datetime,
		  `price` float,
		  `product_item_choice_id` int(11) NOT NULL,
		   `created_at` datetime DEFAULT NULL,
		  `updated_at` datetime DEFAULT NULL,
		  `created_by` int(15) DEFAULT NULL,
		  `updated_by` int(15) DEFAULT NULL,
		  PRIMARY KEY (`order_item_id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ; ";

        $res = Yii::$app->db->createCommand($sql)->execute();

        /* $sql = " CREATE TABLE IF NOT EXISTS `cl_". $new_provider ."_order_items_choices` (
            `id` int(15) NOT NULL AUTO_INCREMENT,
            `order_item_id` int(15) NOT NULL,
            `prod_item_choice_id` int(15) NOT NULL,
            `data_text` varchar(500) NOT NULL,
            `sort_id` int(15) NOT NULL,
            `price` float
            PRIMARY KEY (`order_item_id`)
          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ; ";*/

        /*  $res = Yii::$app->db->createCommand( $sql )->execute();*/

        $sql = " CREATE TABLE IF NOT EXISTS `cl_" . $new_provider . "_products` (
		  `prod_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'product id',
		  `product_title` varchar(500) NOT NULL,
		 `product_desc` text NOT NULL COMMENT 'product custom description',
		  `icon` varchar(100) NOT NULL,
		  `sort_id` int(15) DEFAULT '0',
		  `module` text,
		  `published` int(1),
		   `created_at` datetime DEFAULT NULL,
		  `updated_at` datetime DEFAULT NULL,
		  `created_by` int(15) DEFAULT NULL,
		  `updated_by` int(15) DEFAULT NULL,
		  PRIMARY KEY (`prod_id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ; ";

        $res = Yii::$app->db->createCommand($sql)->execute();

        $sql = " CREATE TABLE IF NOT EXISTS `cl_" . $new_provider . "_order_status` (
		  `order_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'order id',
		  	`status`	tinyint(4) 	,
		  	`user_id` 	int(11),
		  	`created_at` 	datetime,
		  PRIMARY KEY (`order_id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ; ";

        $res = Yii::$app->db->createCommand($sql)->execute();

        $sql = " CREATE TABLE IF NOT EXISTS `cl_" . $new_provider . "_logs` (
		  `lid` int(15) NOT NULL AUTO_INCREMENT COMMENT 'logs id',
		  	`action_type` 	int(11) ,
		  	`created_by` 	int(11),
		  	`created_time` 	datetime,
		  	`details` 	varchar(255),
		  PRIMARY KEY (`lid`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ; ";

        $res = Yii::$app->db->createCommand($sql)->execute();


        $sql = " CREATE TABLE IF NOT EXISTS `cl_" . $new_provider . "_prod_item_choices` (
		   `id` int(15) NOT NULL AUTO_INCREMENT,
			`prod_item_id` int(15) NOT NULL,
			`sort_id` int(11) NOT NULL,
			`title` varchar(255) NOT NULL,
			`description` text NOT NULL,
			`price` float NOT NULL DEFAULT '0',
			 `created_at` datetime DEFAULT NULL,
		  `updated_at` datetime DEFAULT NULL,
		  `created_by` int(15) DEFAULT NULL,
		  `updated_by` int(15) DEFAULT NULL,
			 PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=89 ; ";

        $res = Yii::$app->db->createCommand($sql)->execute();


        // ------------------------- INSERT START DATA FOR NEW PROVIDER

        $sql = " INSERT INTO `cl_" . $new_provider . "_modules` (`module_id`, `module_name`, `sub_module`, `sort_order`, `comment`, `parent_page`, `module_icon`, `link`, `status`, `module_role_id`, `module_type`) VALUES
		(1, 'Diary', 'n', 2, '', '', 'carelink-diary', 'diary', 'y', '|2|3', 'doc-list'),
		(2, 'About Patient ', 'n', 10, '', '', 'ios-contact-outline', 'about_patient', 'y', '|2|3', 'doc-list'),
		(3, 'Implementation Plan', 'n', 9, '', '', 'ios-bookmarks-outline', 'implementation_plan', 'y', '|2|3', 'doc-list'),
		(4, 'Billboard', 'n', 6, '', '', 'app-care', 'billboard', 'y', '|2|3', 'doc-list'),
		(5, 'Calendar', 'n', 7, '', '', 'ios-calendar-outline', 'calendar', 'y', '|2|3|4', 'doc-list'),
		(6, 'Newsletter', 'n', 8, '', '', 'ios-paper-outline', 'newsletter', 'y', '|2|3|4', 'doc-list'),
		(7, 'Messages', 'n', 1, '', '', 'carelink-messages', 'messaging', 'y', '|2|3|4', ''),
		(8, 'Food Menu', 'n', 5, 'Only show food menu. To allow ordering also food_menu_sub_order must be enabled', '', 'carelink-food', 'food', 'y', '|3|4', ''),
		(9, 'Food Menu sub order', 'y', 0, 'Allow to order from food menu', 'food_menu', 'carelink-food', 'food_menu_sub_order', 'y', '4', 'orders-list'),
		(10, 'Services', 'n', 3, '', '', 'carelink-accomp_order', 'core_services', 'y', '|3|4', 'orders-list'),
		(11, 'Order Accompanier', 'y', 0, '', 'core_services', 'carelink-accomp_order', 'core_services_sub_accompanier', 'y', '|3|4', 'product'),
		(12, 'Pharmacy Pickup', 'y', 0, '', 'core_services', 'carelink-medical', 'core_services_sub_pharmacy', 'y', '|3|4', 'product'),
		(13, 'Cancel Accompanier', 'y', 0, '', 'core_services', 'carelink-accomp_cancel', 'core_services_sub_cancel', 'y', '|3|4', 'product'),
		(14, 'Additional Services ', 'n', 4, 'What services are shown and can be ordered in this module is determined by what Products ae entered by Admin', '', 'ios-paper-outline', 'additional_services', 'y', '|3|4', 'orders-list');  ";

        $res = Yii::$app->db->createCommand($sql)->execute();


    }


    // ----------------------------- DELETE PROVIDERS TABLES---------------------------------


    public function actionDeleteProvider($id)
    {

        $model = $this->findModel($id);

        $delete_id = $model->provider_id;

        $sql = " DROP TABLE cl_" . $delete_id . "_documents  ";
        $res = Yii::$app->db->createCommand($sql)->execute();

        $sql = " DROP TABLE cl_" . $delete_id . "prod_items  ";
        $res = Yii::$app->db->createCommand($sql)->execute();

        $sql = " DROP TABLE cl_" . $delete_id . "_prod_item_choices  ";
        $res = Yii::$app->db->createCommand($sql)->execute();

        $sql = " DROP TABLE cl_" . $delete_id . "_modules  ";
        $res = Yii::$app->db->createCommand($sql)->execute();

        $sql = " DROP TABLE cl_" . $delete_id . "_order_status  ";
        $res = Yii::$app->db->createCommand($sql)->execute();

        $sql = " DROP TABLE cl_" . $delete_id . "_orders  ";
        $res = Yii::$app->db->createCommand($sql)->execute();


        $sql = " DROP TABLE cl_" . $delete_id . "_products  ";
        $res = Yii::$app->db->createCommand($sql)->execute();

        $sql = "SELECT * FROM `cl_users` WHERE  `provider_id` = '" . $delete_id . "'  ";
        $res = Yii::$app->db->createCommand($sql)->queryAll();
        foreach ($res as $row) {

            $sql2 = "  DELETE FROM `cl_group_members` WHERE  `user_id` = " . $row['user_id'] . "  AND `group_type` = 'group'  ";
            $res2 = Yii::$app->db->createCommand($sql2)->execute();

            $sql2 = "  DELETE FROM `cl_users` WHERE  `user_id` = " . $row['user_id'] . "   ";
            $res2 = Yii::$app->db->createCommand($sql2)->execute();

        }

    }


}
