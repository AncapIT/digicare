<?php  

namespace app\models;

use app\components\DigiCareHelper;
use Yii;


class OrderItemChoices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cl_'.DigiCareHelper::getProviderId().'_order_item_choices';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_item_id'], 'required'],
            [['order_item_id', 'sort_id'], 'integer'],
            [['data_text'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'price' => Yii::t('app','Price'),
        ];
    }

    static public function createOIC(
        $prod_item_id,
        $oc,
        $description,
        $price,
        $order_item_id
){
        $orderChoice = new OrderItemChoices();
        $orderChoice->prod_item_id = $prod_item_id;
        $orderChoice->product_item_choice_id = $oc;
        $orderChoice->data_text = $description;
        $orderChoice->price = $price;
        $orderChoice->order_item_id =  $order_item_id;
        $orderChoice->save(false);
        return $orderChoice->id;
    }

}
