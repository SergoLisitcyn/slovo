<?php

use yii\db\Migration;

/**
 * Class m211105_103927_update_table_news
 */
class m211105_103927_update_table_news extends Migration
{
    public function up()
    {
        $this->dropColumn('blog', 'date');
        $this->addColumn('blog', 'date', $this->string(255)->defaultValue(null));
        $this->dropColumn('sale_news', 'date');
        $this->addColumn('sale_news', 'date', $this->string(255)->defaultValue(null));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('blog', 'date', $this->string(255)->defaultValue(null));
        $this->addColumn('sale_news', 'date', $this->string(255)->defaultValue(null));
    }
}
