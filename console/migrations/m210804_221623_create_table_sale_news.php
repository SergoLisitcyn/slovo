<?php

use yii\db\Migration;

/**
 * Class m210804_221623_create_table_sale_news
 */
class m210804_221623_create_table_sale_news extends Migration
{
    public function up()
    {
        $this->createTable('sale_news', [
            'id' => $this->primaryKey(),
            'type' => $this->integer(1)->defaultValue(0),
            'name' => $this->string()->notNull(),
            'url' => $this->string()->notNull(),
            'text_preview' => $this->text(),
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
        $this->dropTable('sale_news');
    }
}
