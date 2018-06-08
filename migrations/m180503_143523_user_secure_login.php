<?php

use yii\db\Migration;

class m180503_143523_user_secure_login extends Migration
{
    public function safeUp()
    {
        $this->addColumn(\app\models\User::tableName(),'login_username',$this->boolean()->defaultValue(false));
        $this->renameColumn(\app\models\User::tableName(),'bankid','login_bankid');
    }

    public function safeDown()
    {
        // return false;
        $this->dropColumn(\app\models\User::tableName(),'login_username');
        $this->dropColumn(\app\models\User::tableName(),'login_bankid');
    }

}
