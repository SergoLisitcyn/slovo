<?php

use yii\db\Migration;

/**
 * Class m210914_223204_create_table_calculator
 */
class m210914_223204_create_table_calculator extends Migration
{
    public function up()
    {
        $this->createTable('calculator', [
            'id' => $this->primaryKey(),
            'amount' => $this->integer(11)->defaultValue(40000),
            'min_amount' => $this->integer(11)->defaultValue(15000),
            'term' => $this->integer(11)->defaultValue(10),
            'min_term' => $this->integer(11)->defaultValue(10),
            'rule_violation_percent' => $this->string(20),
            'rate' => $this->string(20),
            'amount_step' => $this->integer(11)->defaultValue(500),
            'term_step' => $this->integer(11)->defaultValue(1)
        ]);
    }

    public function down()
    {
        $this->dropTable('calculator');
    }
}
