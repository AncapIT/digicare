<?php

use yii\db\Migration;

class m180307_232823_add_user_food_col extends Migration
{
    public function safeUp()
    {

        $this->addColumn('cl_users', 'food', $this->integer(1)->defaultValue(0));
        foreach (\app\models\Providers::find()->all() as $provider) {
            $this->dropColumn('cl_' . $provider->provider_id . '_products', 'module');
            $this->addColumn('cl_' . $provider->provider_id . '_products', 'module', $this->text(45));
        }
    }

    public function safeDown()
    {
        // return false;

    }

}
