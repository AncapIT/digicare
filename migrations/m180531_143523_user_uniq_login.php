<?php

/**
 *  NOTE - IMPORTANT INSTRUCTIONS TO DEVELOPER:
 *  1. Any changes made to db must also be implemented in function to create new provider in file controllers/ProviderController.php
 *  2. If updating provider level tables (tables with cl_nn prefix) use functions $this->p_{migrate function}
 */

use yii\db\Migration;

class m180531_143523_user_uniq_login extends Migration
{
    public function safeUp()
    {
        $this->alterColumn(\app\models\User::tableName(), 'login', $this->string()->unique()->notNull());
        $this->renameColumn(\app\models\User::tableName(), 'status', 'login_allowed');
        $this->alterColumn(\app\models\User::tableName(), 'login_allowed', $this->integer(1)->after('login_bankid')->defaultValue(1)->notNull());
    }

    public function safeDown()
    {
    }

}
