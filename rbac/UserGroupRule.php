<?php
namespace app\rbac;

use app\models\User;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 08.05.18
 * Time: 0:54
 */

class UserGroupRule extends \yii\rbac\Rule
{
    public $name = 'userGroup';
    public function execute($user, $item, $params)
    {
        //Get user from DB
        $user = ArrayHelper::getValue($params, 'user', User::findOne($user));
        if ($user) {
            $role = $user->user_role; //Role field from DB

            switch ($item->name){

                case 'superAdmin':
                    return $role == User::ROLE_SUPER_ADMIN;
                    break;
                case 'admin':
                    return $role == User::ROLE_ADMIN;
                    break;
                case 'staff':
                    return $role == User::ROLE_STAFF;
                    break;
                case 'relative':
                    return $role == User::ROLE_RELATIVE;
                    break;
                case 'patient':
                    return $role == User::ROLE_PATIENT;
                    break;
                default:
                    break;

            }
        }
        return false;
    }
}