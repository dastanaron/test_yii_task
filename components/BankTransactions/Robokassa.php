<?php

namespace app\components\BankTransactions;

use app\models\Users;

/**
 * Class Robokassa
 * Это не написанный класс, который предлагает работать с платежной системой.
 * Поскольку самой платежной системы никакой нет, то просто методы, которые всегда будут возввращать true
 * @package app\components\BankTransactions
 */
class Robokassa
{

    /**
     * Некие абстрактные реквизиты платежа
     * @var
     */
    protected $requisites;

    /**
     * Robokassa constructor.
     * @param $clientId
     */
    public function __construct($clientId)
    {
        //Тут мы типа находим нашего пользователя
        $user = Users::find($clientId);

        //Потом с помощью данных пользователя заполняем реквизиты, если это отдельная база, можно реляцией связать
        //Например через Join QueryBuilder или еще как то зависит как хранится все
    }

    /**
     * Предполагам что у нас уже есть все необходимые данные, здесь мы вводим сумму и отправляем
     * @param $value
     * @return bool
     */
    public function sendMoneyToClient($value)
    {
        if(!empty($value))
        {
            return true;
        }
    }
}