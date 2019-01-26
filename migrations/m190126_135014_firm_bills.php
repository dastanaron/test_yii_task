<?php

use yii\db\Migration;

/**
 * Class m190126_135014_firm_bills
 * Счета фирмы с которой будем списывать деньги на призы и другое. Но у нас для теста будет одна запись со счетом на призы
 */
class m190126_135014_firm_bills extends Migration
{
    /**
     * @var string
     */
    public $tableName = 'firm_bills';

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
            'type' => $this->integer()->notNull(),
            'total_sum' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->null(),
            'updated_at' => $this->timestamp()->null(),
        ], $tableOptions);

        //Индекс по типу, так как нам всегда он нужен будет в запросе
        $this->createIndex('idx_type_firm_bills',
            $this->tableName,
            'type'
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

    private function fixtures()
    {
        $sql = 'INSERT INTO `firm_bills` (`id`,`type`,`total_sum`,`created_at`,`updated_at`) VALUES (1,1,100000,\'2019-01-26 19:13:08\',\'2019-01-26 19:13:08\');';
        $this->execute($sql);
    }
}
