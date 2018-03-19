<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ingredients`.
 */
class m180319_174145_create_ingredients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('ingredients', [
            'id'     => $this->primaryKey(),
            'title'  => $this->string()->notNull(),
            'hidden' => $this->boolean()->defaultValue(false),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('ingredients');
    }
}
