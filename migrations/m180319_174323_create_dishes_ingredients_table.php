<?php

use yii\db\Migration;

/**
 * Handles the creation of table `dishes_ingredients`.
 */
class m180319_174323_create_dishes_ingredients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('dishes_ingredients', [
            'dishes_id'      => $this->integer()->notNull(),
            'ingredients_id' => $this->integer()->notNull(),
            'UNIQUE KEY dishes_id_ingredients_id(dishes_id, ingredients_id)'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('dishes_ingredients');
    }
}
