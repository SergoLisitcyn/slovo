<?php

use yii\db\Migration;

/**
 * Class m210804_191257_update_table_user_role
 */
class m210804_191257_update_table_user_role extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'role', $this->string()->defaultValue('client'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'role');
    }
}
