<?php

use yii\db\Migration;

/**
 * Class m190126_132353_prize_delivery
 * Регистрация доставки призов
 */
class m190126_132353_prize_delivery extends Migration
{
    public $tableName = 'prize_delivery';

    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'prize_item_id' => $this->integer()->notNull()->defaultValue(0),
            'count' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->null(),
            'updated_at' => $this->timestamp()->null(),
        ], $tableOptions);

        $this->createIndex(
            'idx_user_delivery',
            $this->tableName,
            'user_id'
        );

        $this->addForeignKey(
            'fk_users_delivery',
            $this->tableName,
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx_prize_item_delivery',
            $this->tableName,
            'user_id'
        );

        $this->addForeignKey(
            'fk_prize_item_delivery',
            $this->tableName,
            'prize_item_id',
            'prize_items',
            'id',
            'CASCADE'
        );


        $this->execute('ALTER TABLE '.$this->tableName.' CHANGE `updated_at` `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->execute('ALTER TABLE '.$this->tableName.' CHANGE `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
