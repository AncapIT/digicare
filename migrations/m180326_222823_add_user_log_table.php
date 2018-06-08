<?php

use yii\db\Migration;

class m180326_222823_add_user_log_table extends Migration
{
    public function safeUp()
    {

        $this->createTable('cl_user_log', [

            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'time' => $this->dateTime(),
            'method' => $this->string(45),
            'result' => $this->string(45),
            'system'=>$this->string(45),
            'ip'=>$this->string(45),
            'os'=>$this->string(64),
        ]);
    }

    public function safeDown()
    {
        // return false;
        $this->dropTable('cl_user_log');
    }

}
