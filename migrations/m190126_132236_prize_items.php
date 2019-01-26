<?php

use yii\db\Migration;

/**
 * Class m190126_132236_prize_items
 * Физические призы, которые доставляются почтой
 */
class m190126_132236_prize_items extends Migration
{
    public $tableName = 'prize_items';

    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'count' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->null(),
            'updated_at' => $this->timestamp()->null(),
        ], $tableOptions);

        //Ставим индекс на число, потому что будем отбирать те, которые не являются пустыми
        $this->createIndex('idx_count',
            $this->tableName,
            'count'
        );

        $this->execute('ALTER TABLE '.$this->tableName.' CHANGE `updated_at` `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->execute('ALTER TABLE '.$this->tableName.' CHANGE `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
