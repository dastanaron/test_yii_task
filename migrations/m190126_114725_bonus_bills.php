<?php

use yii\db\Migration;

/**
 * Class m190126_114725_settings
 * Таблица бонусных счетов пользователей
 */
class m190126_114725_bonus_bills extends Migration
{
    /**
     * @var string
     */
    public $tableName = 'bonus_bills';

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
            'user_id' => $this->integer()->notNull()->defaultValue(0),
            'sum' => $this->float()->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->null(),
            'updated_at' => $this->timestamp()->null(),
        ], $tableOptions);

        $this->execute('ALTER TABLE '.$this->tableName.' CHANGE `updated_at` `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->execute('ALTER TABLE '.$this->tableName.' CHANGE `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');

        $this->createIndex(
            'idx_user',
            $this->tableName,
            'user_id'
        );

        $this->createIndex('idx_sum',
            $this->tableName,
            'sum'
        );

        $this->addForeignKey(
            'fk_users_user',
            $this->tableName,
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
