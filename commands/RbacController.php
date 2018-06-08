<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 30.04.18
 * Time: 13:10
 */

namespace app\commands;



use app\rbac\UserGroupRule;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = \Yii::$app->authManager;
        $auth->removeAll(); //удаляем старые данные
        //Создадим для примера права для доступа к админке
        $dashboard = $auth->createPermission('dashboard');
        $dashboard->description = 'Admin ui';
        $auth->add($dashboard);
        //Включаем наш обработчик
        $rule = new UserGroupRule();
        $auth->add($rule);
        //Добавляем роли
        $user = $auth->createRole('admin');
        $user->description = 'Admin';
        $user->ruleName = $rule->name;
        $auth->add($user);
        $superAdmin = $auth->createRole('superAdmin');
        $superAdmin->description = 'Super Admin';
        $superAdmin->ruleName = $rule->name;
        $auth->add($superAdmin);
        $staff = $auth->createRole('staff');
        $staff->description = 'Staff';
        $staff->ruleName = $rule->name;
        $auth->add($staff);
        $relative = $auth->createRole('relative');
        $relative->description = 'Relative';
        $relative->ruleName = $rule->name;
        $auth->add($relative);
        $patient = $auth->createRole('patient');
        $patient->description = 'Patient';
        $patient->ruleName = $rule->name;
        $auth->add($patient);

    }
}