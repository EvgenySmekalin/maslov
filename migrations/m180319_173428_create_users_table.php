<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m180319_173428_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id'       => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'password' => $this->string(60)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }
}
