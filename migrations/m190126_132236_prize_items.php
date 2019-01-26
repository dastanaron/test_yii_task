<?php

use yii\db\Migration;

/**
 * Class m190126_132236_prize_items
 * Физические призы, которые доставляются почтой
 */
class m190126_132236_prize_items extends Migration
{
    /**
     * @var string
     */
    public $tableName = 'prize_items';

    /**
     * @return bool|void
     */
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

        $this->fixtures();
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable($this->tableName);
    }

    /**
     * Фикстуры, чтобы не придумывать чем наполнить таблицу
     */
    private function fixtures()
    {
        $sql = "INSERT INTO `".$this->tableName."` (`id`,`name`,`count`,`created_at`,`updated_at`) VALUES 
            (1,'Pen',100,'2019-01-26 17:07:15','2019-01-26 17:07:15'),
            (2,'Pencil',200,'2019-01-26 17:07:15','2019-01-26 17:07:15'),
            (3,'Branded mug',10,'2019-01-26 17:07:15','2019-01-26 17:07:15'),
            (4,'Piggy bank',5,'2019-01-26 17:07:15','2019-01-26 17:07:15'),
            (5,'Automobile',2,'2019-01-26 17:07:15','2019-01-26 17:07:15');";

        $this->execute($sql);
    }

}
