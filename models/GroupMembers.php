<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 19.03.18
 * Time: 23:07
 */

namespace app\models;



use app\components\DigiCareHelper;
use Yii;
use yii\db\ActiveRecord;

/**
 * Class GroupMembers
 * @package app\models
 *
 * @property integer $id
 * @property integer $group_id
 * @property integer $user_id
 * @property integer $patient_id
 * @property string $group_type
 * * @property String $created_at
 * @property String $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */

class GroupMembers extends ActiveRecord
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

    public static function tableName()
    {

        return 'cl_group_members';
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    public function getGroup(){
        return $this->hasOne(Groups::className(), ['group_id' => 'group_id']);
    }


}