<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 19.03.18
 * Time: 23:04
 */

namespace app\models;


use Yii;
use yii\db\ActiveRecord;

/**
 * Class Groups
 * @package app\models
 *
 * @property integer $group_id
 * @property string $name
 * @property integer $provider_id
 ** @property String $created_at
 * @property String $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */

class Groups extends ActiveRecord
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

        return 'cl_groups';
    }

    public function getGroupMembers(){
        return $this->hasMany(GroupMembers::className(), ['group_id' => 'group_id']);
    }

    public static function getUserFilter($group_id){
        $filter = [];
        $group = Groups::findOne($group_id);
        foreach ($group->groupMembers as $member){
            $filter[] = $member->user_id;
        }
        return implode(',',$filter);
    }
}