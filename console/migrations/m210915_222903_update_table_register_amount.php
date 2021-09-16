<?php

use yii\db\Migration;

/**
 * Class m210915_222903_update_table_register_amount
 */
class m210915_222903_update_table_register_amount extends Migration
{
    public function up()
    {
        $this->addColumn('register', 'amount', $this->string(20)->defaultValue(40000));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('register', 'amount');
    }
}
