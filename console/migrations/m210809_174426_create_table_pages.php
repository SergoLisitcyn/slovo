<?php

use yii\db\Migration;

/**
 * Class m210809_174426_create_table_pages
 */
class m210809_174426_create_table_pages extends Migration
{
    public function up()
    {
        $this->createTable('pages', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'content' => $this->text(),
            'title' => $this->string()->defaultValue(null),
            'description' => $this->string()->defaultValue(null),
            'keywords' => $this->string()->defaultValue(null),
            'status' => $this->integer(1)->defaultValue(1),
        ]);
    }

    public function down()
    {
        $this->dropTable('pages');
    }
}
