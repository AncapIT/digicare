<?php

namespace app\models;


use app\components\DigiCareHelper;
use DateTime;
use Yii;

/**
 * Class ProductItemsChoices
 * @package app\models
 *
 * @property boolean $published
 * @property String $created_at
 * @property String $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */

class ProductItemsChoices extends \yii\db\ActiveRecord
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


    /**
     * @inheritdoc
     */
    public static function tableName()
    {	
	        return 'cl_'. DigiCareHelper::getProviderId() .'_prod_item_choices';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [];
    }

    static public function getReportDetaisData($item_id){
        $data = [];
        if(isset($item_id) && is_numeric($item_id)){
            $sql = "SELECT u.user_id,u.first_name,  u.last_name, pic.id ,count(DISTINCT oi.order_item_id) as cnt
 FROM cl_". DigiCareHelper::getProviderId() ."_order_items oi
        LEFT JOIN cl_". DigiCareHelper::getProviderId() ."_prod_item_choices pic on oi.product_item_choice_id = pic.id
        LEFT JOIN cl_". DigiCareHelper::getProviderId() ."_product_items pi on oi.prod_item_id = pi.prod_item_id 
         LEFT JOIN cl_". DigiCareHelper::getProviderId() ."_orders o on oi.order_id = o.order_id
        LEFT JOIN  cl_users u on o.patient_id = u.user_id WHERE oi.prod_item_id = ".$item_id." GROUP BY u.user_id ORDER BY u.last_name" ;

            $res = Yii::$app->db->createCommand( $sql )->queryAll();

            foreach ($res as $row){
                $data[$row["id"]][$row["user_id"]]['name'] = $row['first_name']." ".$row['last_name'];
                $data[$row["id"]][$row["user_id"]]['cnt'] = $row['cnt'];
            }
        }


        return $data;
    }

}
