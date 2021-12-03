<?php

use yii\db\Migration;

/**
 * Class m211203_090913_update_main_page_text
 */
class m211203_090913_update_main_page_text extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $query = "UPDATE main_page SET text = CONCAT('<div class=desktop-version>', text, '</div>') WHERE title = 'Займы'";
        $this->execute($query);
    }
}
