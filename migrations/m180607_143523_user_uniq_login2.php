<?php

/**
 *  NOTE - IMPORTANT INSTRUCTIONS TO DEVELOPER:
 *  1. Any changes made to db must also be implemented in function to create new provider in file controllers/ProviderController.php
 *  2. If updating provider level tables (tables with cl_nn prefix) use functions $this->p_{migrate function}
 */

use yii\db\Migration;

class m180607_143523_user_uniq_login2 extends Migration
{
    public function safeUp()
    {
        $this->alterColumn(\app\models\User::tableName(), 'login_username', $this->integer(1)->after('login_bankid')->defaultValue(0)->notNull());
        $this->alterColumn(\app\models\User::tableName(), 'login_bankid', $this->integer(1)->defaultValue(1)->notNull());
    }

    public function safeDown()
    {
    }

}
