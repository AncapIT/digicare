<?php

use yii\db\Migration;

class m180305_220623_add_read_by_admin extends Migration
{
    public function safeUp()
    {    

        $this->addColumn('cl_messages', 'read_by_admin', $this->integer()->defaultValue(0)->after('status')   );
        $this->dropColumn('cl_messages','group_id');
        $this->renameColumn('cl_messages','mid','id');
        $this->dropColumn('cl_messages','status');
        $this->addColumn('cl_messages', 'patient_id', $this->integer() );

    }

    public function safeDown()
    {
         // return false;
    }
 
}
