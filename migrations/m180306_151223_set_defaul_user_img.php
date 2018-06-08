<?php

use yii\db\Migration;

class m180306_151223_set_defaul_user_img extends Migration
{
    public function safeUp()
    {

        $this->update('cl_users', ['photo'=>'def_img.png'], ['photo'=>'']);

    }

    public function safeDown()
    {
        // return false;

    }

}
