<?php

namespace app\models;

use Yii;

 
class Relations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cl_group_members';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'parent_id'], 'required'],
            [['user_id', 'parent_id', 'group_id' ], 'integer'],
            [[ 'group_type' ], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app','Ref ID'),
            'user_id' => Yii::t('app','User ID'),
            'parent_id' => Yii::t('app','User Parent ID'),
            'group_type' => Yii::t('app','Group Type')
        ];
    }


}
