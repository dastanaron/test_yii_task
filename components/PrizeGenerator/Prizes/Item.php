<?php

namespace app\components\PrizeGenerator\Prizes;

use app\components\PrizeGenerator\Interfaces\Prizes;

/**
 * Class Item
 * Предмет. Стратегия должна искать предмет в базе данных, по списку присутствующих, т.е. count > 0, позволяет отказаться
 * или получить, в таком случае нам нужно зарегистрировать заказ в prize_delivery
 * @package app\components\PrizeGenerator\Prizes
 */
class Item implements Prizes
{
    public function take()
    {
        // TODO: Implement take() method.
    }

    public function refuse()
    {
        // TODO: Implement refuse() method.
    }

}