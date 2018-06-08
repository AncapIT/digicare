<?php

use app\models\ProvidersMigration;

class m180403_002623_add_published extends ProvidersMigration
{
    public function safeUp()
    {
            $this->p_addColumn('products', 'published', $this->integer(1)->defaultValue(1));
            $this->p_addColumn('documents', 'published', $this->integer(1)->defaultValue(1));
    }

    public function safeDown()
    {
        // return false;
            $this->p_dropColumn('products', 'published');
            $this->p_dropColumn('documents', 'published');
    }

}
