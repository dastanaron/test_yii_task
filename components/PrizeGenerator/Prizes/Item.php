<?php

namespace app\components\PrizeGenerator\Prizes;

use app\components\PrizeGenerator\Interfaces\Prizes;
use app\components\PrizeGenerator\Traits\Refuse;

/**
 * Class Item
 * Предмет. Стратегия должна искать предмет в базе данных, по списку присутствующих, т.е. count > 0, позволяет отказаться
 * или получить, в таком случае нам нужно зарегистрировать заказ в prize_delivery
 * @package app\components\PrizeGenerator\Prizes
 */
class Item implements Prizes
{
    use Refuse;

    public function take()
    {
        // TODO: Implement take() method.
    }

    public function getName()
    {
        return 'item';
    }

    public function getValue()
    {
        // TODO: Implement getValue() method.
    }


}