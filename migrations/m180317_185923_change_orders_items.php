<?php

use app\models\ProvidersMigration;
class m180317_185923_change_orders_items extends ProvidersMigration
{
    public function safeUp()
    {
         
        $this->p_dropTable('order_item_choices');
        $this->p_addColumn('order_items','product_item_choice_id',$this->integer());
        

    }

    public function safeDown()
    {
        // return false;

    }

}
