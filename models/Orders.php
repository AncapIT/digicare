<?php

namespace app\models;

use app\components\DigiCareHelper;
use DateTime;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;


/**
 * Class Orders
 * @package app\models
 *
 * @property boolean $published
 * @property String $created_at
 * @property String $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 */
class Orders extends ActiveRecord
{


    public $modifier;

    public function beforeSave($insert)
    {
        date_default_timezone_set(Yii::$app->params['timeZone']);
        $user_id = isset($this->modifier)? $this->modifier->user_id : Yii::$app->user->id;
        if($this->isNewRecord){
            $this->created_at = date('Y-m-d H:i:s');
            $this->created_by = $user_id;
        }
            $this->updated_at = date('Y-m-d H:i:s');
            $this->updated_by = $user_id;

        $this->on(Orders::EVENT_ORDER_CREATED,['app\models\DigiMailer','sendNewOrderAdded'],$this);
        date_default_timezone_set(Yii::$app->params['timeZone']);
        $this->update_date = date('Y-m-d H:i:s');
        return parent::beforeSave($insert);
    }

    public function getCreatedUpdated(){
        $html = '';
        if(isset($this->created_at)){
            $crUser = User::findOne($this->created_by);
            if(isset($crUser))
                $html .= " <p>Created by ".$crUser->getFullname()." at ". $this->created_at."</p>";
        }
        if(isset($this->updated_at)){
            $upUser = User::findOne($this->updated_by);
            if(isset($upUser))
                $html .= " <p>Updated by ".$upUser->getFullname()." at ". $this->updated_at."</p>";
        }
        return $html;
    }

    public $isFoodOrder;
    public $sub_user_id;
    const EVENT_ORDER_CREATED = 'event_order_created';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {

        return 'cl_' . DigiCareHelper::getProviderId() . '_orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_title', 'user_id', 'product_id'], 'required', 'on' => 'create'],
            [['user_id', 'order_status', 'product_id'], 'integer'],
            [['order_title', 'product_type', 'create_date','patient_id', 'update_date','product_module'], 'safe'],
            [['price'], 'number'],
            [['order_title'], 'string', 'max' => 150],
            //['product_id', 'validateIfUserCanOrderMenu'],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => Yii::t('app', 'Order ID'),
            'order_title' => Yii::t('app', 'Order Title'),
            'user_id' => Yii::t('app', 'User'),
            'patient_id'=> Yii::t('app', 'Patient'),
            'create_date' => Yii::t('app', 'Create Date'),
            'update_date' => Yii::t('app', 'Update Date'),
            'price' => Yii::t('app', 'Price'),
            'order_status' => Yii::t('app', 'Status'),
        ];
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    public function getPatient()
    {
        return $this->hasOne(User::className(), ['user_id' => 'patient_id']);
    }

    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::className(), ['order_id' => 'order_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['prod_id' => 'product_id']);
    }


    /*  ---------------------------- GET ORDER STATUS TITLE -----------------------------------------  */

    public function getOrder_status_title($title)
    {
        $item_name = '';
        foreach ($GLOBALS["order_status"] as $key => $value) {
            if ($title == $key) {
                $item_name = $value;
            }
        }
        return $item_name;
    }


    /*  ---------------------------- GET  USER TITLE IN ROW -----------------------------------------  */

    public function getUser_name($user_id)
    {

        $output = '';
        $sql = "SELECT * FROM  cl_users WHERE user_id = '" . $user_id . "'  ";
        $res = Yii::$app->db->createCommand($sql)->queryAll();
        foreach ($res as $row) {
            $output = $output . $row['first_name'] . " " . $row['last_name'] . ' ';
        }

        return $output;
    }


    /*  ---------------------------- GET RELATIONS LIST -----------------------------------------  */

    public function getUsers_list()
    {

        $output_list = array();
        $sql = "SELECT * FROM  cl_users_xref as xref, cl_users as u  WHERE  u.user_id =  xref.user_id  AND u.login <> 'admin'   AND u.user_role = 4   ";
        $res = Yii::$app->db->createCommand($sql)->queryAll();
        foreach ($res as $row) {
            $output_list[$row['user_id']] = $row['first_name'] . " " . $row['last_name'];
        }

        return $output_list;
    }


    /*  ---------------------------- GET RELATIONS LIST -----------------------------------------  */

    public function getOrder_items_data()
    {
        $output_list =[];
        foreach ($this->orderItems as $item) {
            //$item = $row->product_item;
            if($item->price > 0){
                $output_list[$item->order_item_id] = '<b>' . $item->title . "</b>: " . $item->data_text . "<br> ".Yii::t('app','price').': ' . $item->price;
            }else{
                $output_list[$item->order_item_id] = '<b>' . $item->title . "</b>: " . $item->data_text ;

            }
        }

        return $output_list;
    }

    /* -------------- UPDATE STATUS --------------------------*/

    public function updateStatus($status)
    {
        $oldStatus = $this->order_status;
        $this->order_status = $status;

        if ($this->save(false)) {

            $orderStatus = new OrderStatus([
                'order_id' => $this->order_id,
                'user_id' => Yii::$app->user->id,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            $oStatus = clone $orderStatus;
            $oStatus->status = $this->order_status;
            $oStatus->save();

            if ($this->order_status != 5) { // canceled
                foreach ($GLOBALS["order_status"] as $sid => $status) {
                    if ($sid > $oldStatus && $sid < $this->order_status) {
                        $oStatus = clone $orderStatus;
                        $oStatus->status = $sid;
                        $oStatus->save();
                    }
                }
            }

            return true;
        }
    }


    /*---------------- CHECK IF USER HAVE ALREADY MENU ORDERED --------------------*/

    public function checkIfUserOrderedMenu()
    {
        //data check is comented. Uncomment it when it will be necessary.
        /*  $day = date('w',strtotime($this->create_date));
          $week_start = date('Y-m-d H:i:s', strtotime($this->create_date.' -'.$day.' days'));
          $week_end = date('Y-m-d H:i:s', strtotime($this->create_date.' +'.(6-$day).' days'));*/
        $orders = Orders::find()
            //  ->where(" `create_date` > '".$week_start ."' AND `create_date` <= '".$week_end."' AND `order_status` !=5 ")
            ->where(['user_id' => $this->user_id, 'product_id' => $this->product_id])->all();
        return count($orders) > 0;
    }

    /*-------------------- CHECK IF SUB USER CAN ORDER -------------------------*/

    public function checkIfSubUserCanOrder()
    {
        $can = false;
        $user = User::findOne($this->user_id);
        if (isset($user)) {
            $module = Modules::find()->where(['link' => 'food_menu_sub_order'])->all();
            foreach ($module as $m) {
                if (strpos($m->module_role_id, $user->user_role)) {
                    $can = true;
                }
            }
        }
        return $can;
    }

    /*---------------------- CHECK IF PATIENT CAN ORDER ------------------------*/
    public function checkIfPatientCanOrder()
    {
        $user = User::find()->where(['user_id' => $this->patient_id, 'food' => 1])->one();
        return isset($user);
    }

    public function validateIfUserCanOrderMenu()
    {
        $product = Products::findOne($this->product_id);
        if (isset($product) && $product->module == 'food_menu') {
            if ($this->checkIfUserOrderedMenu()) {
                $this->addError('product_id', Yii::t('app', 'User already ordered this food menu this week'));
            }
            if (isset($this->user_id) && !$this->checkIfSubUserCanOrder()) {
                $this->addError('product_id', Yii::t('app', 'User can not order food'));
            }
            if (!$this->checkIfPatientCanOrder()) {
                $this->addError('product_id', Yii::t('app', 'Patient can not order food'));
            }
        }
    }

    public function ifUserCanOrderMenu()
    {
        $this->validateIfUserCanOrderMenu();
        return count($this->getErrors()) == 0;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * FInd records for "new orders report"
     */

    public function searchNew($params)
    {

        $query = Orders::find()->where(['in', 'order_status', [1, 2]]);


        if ($this->isFoodOrder === true) {
            $query->andWhere(['product_module' => 'food_menu']);
        } elseif ($this->isFoodOrder === false) {
            $query->andWhere(['!=','product_module', 'food_menu']);
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Providers::getNumUiItems(),
            ],
        ]);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'order_id' => $this->order_id,
            'user_id' => $this->user_id,
            'patient_id' => $this->patient_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
            'price' => $this->price,
        ])->andFilterWhere(['like', 'order_title', $this->order_title]);;


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Providers::getNumUiItems(),
            ],
        ]);

        return $dataProvider;
    }


    /**
     * @param $params
     * @return ActiveDataProvider
     * FInd records for "new orders report"
     */

    public function search($params)
    {

        $query = Orders::find();

        if ($this->isFoodOrder === true) {
            $query->andWhere(['product_module' => 'food_menu']);
        } elseif ($this->isFoodOrder === false) {
            $query->andWhere(['!=','product_module', 'food_menu']);
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Providers::getNumUiItems(),
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'order_id' => $this->order_id,
            'user_id' => $this->user_id,
            'patient_id' => $this->patient_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
            'order_status' => $this->order_status,
            'price' => $this->price,
        ])->andFilterWhere(['like', 'order_title', $this->order_title]);;


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Providers::getNumUiItems(),
            ],
        ]);

        return $dataProvider;
    }


}
