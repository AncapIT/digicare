<?php

use app\models\ProvidersMigration;

class m180306_112323_change_orders_db_structure extends ProvidersMigration
{
    public function safeUp()
    {
        $this->p_addColumn('orders', 'product_id', $this->integer());
        $this->p_addColumn('order_items', 'title', $this->string(255));
        $this->p_renameColumn('order_items', 'order_data', 'data_text');
        $this->p_addColumn('order_items', 'data_datetime', $this->dateTime());
        $this->p_addColumn('order_items', 'price', $this->float());
        $this->p_createTable('order_item_choices', [
            'id' => $this->primaryKey(),
            'order_item_id' => $this->integer(),
            'product_item_choice_id' => $this->integer(),
            'sort_id' => $this->integer(),
            'data_text' => $this->string(),
            'price' => $this->float()
        ]);

    }

    public function safeDown()
    {
        // return false;
        $this->p_dropTable('order_item_choices');
        $this->p_dropColumn('orders', 'product_id');
        $this->p_dropColumn('order_items', 'title');
        $this->p_renameColumn('order_items', 'data_text', 'order_data');
        $this->p_dropColumn('order_items', 'data_datetime');
        $this->p_dropColumn('order_items', 'price');

    }

}
