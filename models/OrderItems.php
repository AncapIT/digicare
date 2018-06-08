<?php  

namespace app\models;

use app\components\DigiCareHelper;
use DateTime;
use Yii;

/**
 * Class OrderItems
 * @package app\models
 *
 * @property integer $order_item_id
 * @property integer $order_id
 * @property integer $prod_item_id
 * @property integer $product_item_choice_id
 * @property string $data_text
 * @property integer $sort_id
 * @property string $title
 * @property string $data_datetime
 * @property float $price
 * @property boolean $published
 * @property String $created_at
 * @property String $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */

class OrderItems extends \yii\db\ActiveRecord
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
        return 'cl_'.DigiCareHelper::getProviderId().'_order_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'title'], 'required'],
            [['order_item_id', 'order_id', 'prod_item_id', 'sort_id'], 'integer'],
            [['data_text'], 'string', 'max' => 500],
        ];
    }

    public function getProductItem(){
        return $this->hasOne(ProductItems::className(),['prod_item_id'=>'order_item_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => Yii::t('app','Order ID'),
            'order_title' => Yii::t('app','Order Title'),
            'user_id' => Yii::t('app','User'),
       //     'product_type' => Yii::t('app','Product Type'),
            'create_date' => Yii::t('app','Create Date'),
            'update_date' => Yii::t('app','Update Date'),
            'price' => Yii::t('app','Price'),
            'order_status' => Yii::t('app','Status'),
        ];
    }


}
