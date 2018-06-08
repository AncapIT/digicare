<?php

use app\models\ProvidersMigration;

class m180215_170823_create_main_tables extends ProvidersMigration
{
    public function safeUp()
    {
        // $this->execute(file_get_contents(__DIR__ . '/start-dump.sql'));  //   <-------- START DUMP

        /*
        $this->dropTable('cl_1_items');
        $this->dropTable('cl_1_menu');

        $this->dropColumn('cl_1_orders', 'selected_items');

        $this->dropTable('cl_1_order_items');
        */
        $this->p_createTable('order_items', [

            'order_item_id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'prod_item_id' => $this->integer(),
            'order_data' => $this->string(),
            'sort_id' => $this->integer(),
        ]);


    }

    public function safeDown()
    {
        // return false;
    }

}
