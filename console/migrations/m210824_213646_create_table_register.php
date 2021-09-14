<?php

use yii\db\Migration;

/**
 * Class m210824_213646_create_table_register
 */
class m210824_213646_create_table_register extends Migration
{
    public function up()
    {
        $this->createTable('register', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'surname' => $this->string(255)->notNull(),
            'patronymic' => $this->string(255)->defaultValue(null),
            'sex' => $this->integer(1)->notNull(),
            'phone' => $this->string(255)->notNull(),
            'birthdate' => $this->string(255)->notNull(),
            'tin' => $this->string(255)->notNull(),
            'term' => $this->string(255)->notNull(),
            'link' => $this->string(255)->defaultValue(null),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('register');
    }
}
