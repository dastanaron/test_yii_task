<?php

use yii\db\Migration;

/**
 * Class m190126_113527_users
 * Таблица самих пользователей для авторизации и связок
 */
class m190126_113527_users extends Migration
{
    /**
     * @var string
     */
    public $tableName = 'users';

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
            'login' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'active' => $this->integer(1)->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->null(),
            'updated_at' => $this->timestamp()->null(),
        ], $tableOptions);

        //Делаем индекс по логину для быстрого поиска юзера
        $this->createIndex('idx_login',
            $this->tableName,
            'login',
            true
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
     * ФИкстура для первого пользователя, чтобы не регистрироваться логин user пароль 123456, если не сменить ключ соли
     */
    private function fixtures()
    {
        $passwordHash = '$2y$13$BNdGfB6fXCDmzp6n4/I7PO5FMFoo9TjXBG5a7/pYwanF1BKNvR6Zy';
        $sql = "INSERT INTO `users` (`id`,`login`,`password`,`active`,`created_at`,`updated_at`) VALUES (1,'user','$passwordHash',1,'2019-01-26 17:12:36','2019-01-26 17:12:36');";
        $this->execute($sql);
    }
}
