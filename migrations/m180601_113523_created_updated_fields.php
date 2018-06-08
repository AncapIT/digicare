<?php

/**
 *  NOTE - IMPORTANT INSTRUCTIONS TO DEVELOPER:
 *  1. Any changes made to db must also be implemented in function to create new provider in file controllers/ProviderController.php
 *  2. If updating provider level tables (tables with cl_nn prefix) extend \app\models\ProvidersMigration and use functions $this->p_{migrate function}
 *  Table names should be without prefix
 */

class m180601_113523_created_updated_fields extends \app\models\ProvidersMigration
{
    private $p_tables = ['documents','modules','orders','order_items','products','product_items','prod_item_choices'];
    private $tables =  ['cl_groups','cl_group_members','cl_messages','cl_providers'];
    public function safeUp()
    {

        foreach ($this->p_tables as $table){
            $this->p_addColumn($table, 'created_at', $this->timestamp());
            $this->p_addColumn($table, 'created_by', $this->integer(15));
            $this->p_addColumn($table, 'updated_at', $this->timestamp());
            $this->p_addColumn($table, 'updated_by', $this->integer(15));
        }

        foreach ($this->tables as $table){
            $this->addColumn($table, 'created_at', $this->timestamp());
            $this->addColumn($table, 'created_by', $this->integer(15));
            $this->addColumn($table, 'updated_at', $this->timestamp());
            $this->addColumn($table, 'updated_by', $this->integer(15));
        }

        //
        $this->addColumn('cl_users', 'created_by', $this->integer(15));
        $this->addColumn('cl_users', 'updated_by', $this->integer(15));
    }

    public function safeDown()
    {
        foreach ($this->p_tables as $table){
            $this->p_dropColumn($table, 'created_at');
            $this->p_dropColumn($table, 'created_by');
            $this->p_dropColumn($table, 'updated_at');
            $this->p_dropColumn($table, 'updated_by');
        }

        foreach ($this->tables as $table){
            $this->dropColumn($table, 'created_at');
            $this->dropColumn($table, 'created_by');
            $this->dropColumn($table, 'updated_at');
            $this->dropColumn($table, 'updated_by');
        }
        $this->dropColumn('cl_users', 'created_by');
        $this->dropColumn('cl_users', 'updated_by');
    }

}
