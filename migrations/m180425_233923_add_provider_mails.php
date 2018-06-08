<?php

use yii\db\Migration;

class m180425_233923_add_provider_mails extends Migration
{
    public function safeUp()
    {
        $this->addColumn('cl_providers','email_alerts_messages',$this->text());
        $this->addColumn('cl_providers','email_alerts_orders',$this->text());
    }

    public function safeDown()
    {
        // return false;
        $this->dropColumn('cl_providers','email_alerts_messages');
        $this->dropColumn('cl_providers','email_alerts_orders');
    }

}
