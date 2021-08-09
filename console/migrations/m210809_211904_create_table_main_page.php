<?php

use yii\db\Migration;

/**
 * Class m210809_211904_create_table_main_page
 */
class m210809_211904_create_table_main_page extends Migration
{
    public function up()
    {
        $this->createTable('main_page', [
            'id' => $this->primaryKey(),
            'text' => $this->text()->defaultValue(null),
            'title' => $this->string()->defaultValue(null),
            'description' => $this->string()->defaultValue(null),
            'keywords' => $this->string()->defaultValue(null),
        ]);
    }

    public function down()
    {
        $this->dropTable('main_page');
    }
}
