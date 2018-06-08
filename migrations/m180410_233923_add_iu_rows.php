<?php

use yii\db\Migration;

class m180410_233923_add_iu_rows extends Migration
{
    public function safeUp()
    {
        $this->addColumn('cl_providers','ui_rows',$this->integer(4)->defaultValue(100));
    }

    public function safeDown()
    {
        // return false;
        $this->dropColumn('cl_providers', 'ui_rows');
    }

}
