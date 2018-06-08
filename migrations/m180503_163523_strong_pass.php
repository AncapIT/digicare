<?php

use yii\db\Migration;

class m180503_163523_strong_pass extends Migration
{
    public function safeUp()
    {
        $this->addColumn(\app\models\Providers::tableName(),'password_min_length',$this->integer()->defaultValue(8));
        $this->addColumn(\app\models\Providers::tableName(),'password_hard',$this->boolean()->defaultValue(false));
    }

    public function safeDown()
    {
        // return false;
        $this->dropColumn(\app\models\User::tableName(),'password_min_length');
        $this->dropColumn(\app\models\User::tableName(),'password_hard');
    }

}
