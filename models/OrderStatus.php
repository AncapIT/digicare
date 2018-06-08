<?php

namespace app\models;

use app\components\DigiCareHelper;
use Yii;

/**
 * This is the model class for table "cl_1_order_status".
 *
 * @property integer $order_id
 * @property integer $status
 * @property integer $user_id
 * @property string $created_at
 */
class OrderStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cl_'.DigiCareHelper::getProviderId().'_order_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'status', 'user_id', 'created_at'], 'required'],
            [['order_id', 'status', 'user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['order_id', 'status'], 'unique', 'targetAttribute' => ['order_id', 'status'], 'message' => 'The combination of Order ID and Status has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => Yii::t('app','Order ID'),
            'status' => Yii::t('app','Status'),
            'user_id' => Yii::t('app','User ID'),
            'created_at' => Yii::t('app','Created At'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }
}
