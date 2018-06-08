<?php

use app\models\ProvidersMigration;

class m180219_161643_orders_and_logs extends ProvidersMigration
{
    public function safeUp()
    {
        $this->addColumn('cl_providers', 'stripe_currency', $this->string());
        $this->p_createTable('logs', [

            'lid' => $this->primaryKey(),
            'action_type' => $this->integer(),
            'created_by' => $this->integer(),
            'created_time' => $this->datetime(),
            'details' => $this->string(),
        ]);
        $this->p_addColumn('orders', 'payment_ref', $this->string());


    }

    public function safeDown()
    {
        return false;
    }

}
