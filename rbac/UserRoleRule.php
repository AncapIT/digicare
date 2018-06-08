<?php
namespace app\rbac;

use app\models\User;
use yii\helpers\ArrayHelper;
use yii\rbac\Rule;

/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 30.04.18
 * Time: 13:03
 */

class UserRoleRule extends Rule
{
    public $name = 'userRole';
    public function execute($user, $item, $params)
    {
        //Get users from DB
        $user = ArrayHelper::getValue($params, 'user', User::findOne($user));
        var_dump($user);
        if ($user) {
            $role = $user->user_role; //role field from DB

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