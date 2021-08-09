<?php

use yii\db\Migration;

/**
 * Class m210804_185522_create_table_user_profile
 */
class m210804_185522_create_table_user_profile extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_profile', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'full_name' => $this->string(255),
            'public_email' => $this->string(255),
            'profession' => $this->string(255),
            'about_me' => $this->text(),
            'avatar' => $this->string(255),
            'avatar_crop' => $this->string(255),
            'avatar_cropped' => $this->string(255),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-user_profile-user_id',
            'user_profile',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-user_profile-user_id',
            'user_profile',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-user_profile-user_id',
            'user_profile'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-user_profile-user_id',
            'user_profile'
        );

        $this->dropTable('user_profile');
    }
}
