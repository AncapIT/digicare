<?php

use yii\db\Migration;

class m180307_222823_add_user_consent_col extends Migration
{
    public function safeUp()
    {

       $this->addColumn('cl_users', 'consent', $this->integer(1)->defaultValue(0));
        $this->addColumn('cl_users','consent_time',$this->dateTime());
        $this->addColumn('cl_users','consent_user_id',$this->integer());
    }

    public function safeDown()
    {
        // return false;

    }

}
