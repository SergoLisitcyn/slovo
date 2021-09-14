<?php

use yii\db\Migration;

/**
 * Class m210914_194902_create_table_otkaz_partners
 */
class m210914_194902_create_table_otkaz_partners extends Migration
{
    public function up()
    {
        $this->createTable('otkaz_page', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->defaultValue(null),
            'text_top' => $this->text(),
            'text_bottom' => $this->text(),
            'title_seo' => $this->string(255)->defaultValue(null),
            'description' => $this->string(255)->defaultValue(null),
            'keywords' => $this->string(255)->defaultValue(null),
        ]);
        $this->createTable('partners', [
            'id' => $this->primaryKey(),
            'image' => $this->string(255)->defaultValue(null),
            'advantages' => $this->string(255)->defaultValue(null),
            'srok' => $this->string(255)->notNull(),
            'stavka' => $this->string(255)->notNull(),
            'summa' => $this->string(255)->notNull(),
            'link' => $this->string(255)->notNull(),
            'best_deal' => $this->integer(11)->defaultValue(0),
            'gesv' => $this->string(255)->defaultValue(null),
            'sort' => $this->integer(11)->defaultValue(0),
            'status' => $this->integer(255)->defaultValue(1),
        ]);
    }

    public function down()
    {
        $this->dropTable('otkaz_page');
        $this->dropTable('partners');
    }
}
