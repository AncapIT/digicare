<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 26.03.18
 * Time: 22:31
 */

namespace app\models;


use Yii;
use yii\db\ActiveRecord;

/**
 * Class UserLog
 * @package app\models
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $time
 * @property string $method
 * @property string $result
 * @property string $system
 * @property string $ip
 * @property string $os
 *
 */

class UserLog extends  ActiveRecord
{

    public static function tableName(){
        return 'cl_user_log';
    }
    public function saveLog(){
        date_default_timezone_set(Yii::$app->params['timeZone']);
        $this->time = date('Y-m-d H:i:s');
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->os=$_SERVER['HTTP_USER_AGENT'];
        $this->save(false);
    }
}