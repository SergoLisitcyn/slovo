<?php

use yii\db\Migration;

/**
 * Class m211107_124322_update_table_main_page
 */
class m211107_124322_update_table_main_page extends Migration
{
    public function up()
    {
        $this->addColumn('main_page', 'metrics', $this->text()->defaultValue(null));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('main_page', 'metrics');
    }
}
