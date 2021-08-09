<?php

use yii\db\Migration;

/**
 * Class m210809_182109_create_table_reviews
 */
class m210809_182109_create_table_reviews extends Migration
{
    public function up()
    {
        $this->createTable('reviews', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'city' => $this->string()->defaultValue(null),
            'email' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'image' => $this->string()->defaultValue(null),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'status' => $this->integer(1)->defaultValue(0),
            'sort' => $this->integer(1)->defaultValue(0)
        ]);
    }

    public function down()
    {
        $this->dropTable('reviews');
    }
}
