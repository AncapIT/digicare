<?php

use app\models\ProvidersMigration;

class m180307_133923_change_orders_db_structure_2 extends ProvidersMigration
{
    public function safeUp()
    {

        $this->p_dropColumn('products', 'page_link');
        $this->p_dropColumn('products', 'product_type');
        $this->p_addColumn('products', 'module', $this->integer());
        $this->p_dropColumn('orders', 'product_type');
        $this->p_addColumn('orders', 'patient_id', $this->integer());

    }

    public function safeDown()
    {
        // return false;

        $this->p_dropColumn('products', 'module');
        $this->p_dropColumn('orders', 'patient_id');

    }

}
