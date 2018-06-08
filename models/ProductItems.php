<?php

namespace app\models;

/**
 * Class ProductItems
 * @package app\models
 *
 *
 * @property integer $prod_item_id
 * @property  integer  	$product_id
 * @property integer $sort_id
 * @property boolean $published
 * @property String $created_at
 * @property String $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */

use app\components\DigiCareHelper;
use Yii;

class ProductItems extends \yii\db\ActiveRecord
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
     *
     *
     */
    public static function tableName()
    {	
	        return 'cl_'. DigiCareHelper::getProviderId() .'_product_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [];
    }

    public function getItemsChoices(){
        return $this->hasMany(ProductItemsChoices::className(),['prod_item_id'=>'prod_item_id']);
    }



}
