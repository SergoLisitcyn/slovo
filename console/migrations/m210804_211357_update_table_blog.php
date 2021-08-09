<?php

use yii\db\Migration;

/**
 * Class m210804_211357_update_table_blog
 */
class m210804_211357_update_table_blog extends Migration
{
    public function up()
    {
        $this->addColumn('blog', 'text_preview', $this->text());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('blog', 'text_preview');
    }
}
