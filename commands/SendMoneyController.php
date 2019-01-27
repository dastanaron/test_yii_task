<?php

namespace app\commands;

use app\components\BankTransactions\Robokassa;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * Class SendMoneyController
 * Иммитация отправки
 * @package app\commands
 */
class SendMoneyController extends Controller
{

    public function options($actionID)
    {
        return ['batch'];
    }

    public function optionAliases()
    {
        return ['b' => 'batch'];
    }



    public function actionIndex($batch = 1)
    {

        /*Здесь по идее у нас должна быть некая таблица которая хранит не отправленные переводы. Я такую не делал,
        потому что у меня непосредственно сама стратегия отсылает деньги, но там как раз можно обработать ошибочную отправку,
        а после отправлять их консольной командой.
        Делаем запрос, который нам вернет пачку, указанного количества не отправленных средств, и это будет массив таким числом,
        который мы передали в качестве аргумента batch
         *
         */

        //Примерно такая структура нужна. И примерно такой запрос будет, только с помощью модели
        $sql = "Select * FROM 'неотправленные платежи' WHERE completed != 1 ORDER BY publish_date LIMIT $batch";
        $sample = [
            [
                'userId' => 1,
                'sum' => 100,
                'currency' => 'EURO',
                'completed' => 0,
            ]
        ];

        foreach($sample as $element)
        {
            $robokassa = new Robokassa($element['userId']);
            $result = $robokassa->sendMoneyToClient($element['sum']);

            if($result) {
                //Записываем в базу пометку о том, что completed = 1. Т.е. отправлена
                $this->stdout("Send userId: " . $element['userId'] . ' sum: ' . $element['sum'] . ' is completed' . PHP_EOL, Console::BG_GREEN);
            }
            else
            {
                //Здесь нужно выдать ошибку, что какая то транзакция не удалась.
                $this->stdout("Send userId: " . $element['userId'] . ' sum: ' . $element['sum'] . ' is impossible' . PHP_EOL, Console::BG_RED);
            }
        }


        return ExitCode::OK;
    }
}
