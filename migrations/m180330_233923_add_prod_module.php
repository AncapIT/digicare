<?php

use app\models\ProvidersMigration;

class m180330_233923_add_prod_module extends ProvidersMigration
{
    public function safeUp()
    {
            $this->p_addColumn('orders', 'product_module', $this->string(64)->defaultValue(' '));

    }

    public function safeDown()
    {
        // return false;
            $this->p_dropColumn('orders', 'product_module');

    }

}
