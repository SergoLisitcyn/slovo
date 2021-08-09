<?php

use yii\db\Migration;

/**
 * Class m210804_194106_create_table_blog
 */
class m210804_194106_create_table_blog extends Migration
{
    public function up()
    {
        $this->createTable('blog', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'url' => $this->string()->notNull(),
            'content' => $this->text(),
            'date' => $this->dateTime(),
            'title' => $this->string(),
            'description' => $this->string(),
            'keywords' => $this->string(),
            'sort' => $this->integer(11)->defaultValue(0),
            'status' => $this->integer(1)->defaultValue(1),
        ]);
    }

    public function down()
    {
        $this->dropTable('blog');
    }
}
