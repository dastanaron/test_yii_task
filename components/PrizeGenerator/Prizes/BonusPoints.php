<?php

namespace app\components\PrizeGenerator\Prizes;

use app\components\PrizeGenerator\Interfaces\Prizes;
use app\components\PrizeGenerator\Traits\Refuse;

/**
 * Class BonusPoints
 * Бонусы на счет, стратегия позволяет отказаться от них или получить и зачислить на бонусный счет
 * @package app\components\PrizeGenerator\Prizes
 */
class BonusPoints implements Prizes
{
    use Refuse;

    const NAME = 'Bonus points';

    public function take()
    {
        // TODO: Implement take() method.
    }

    public function getName()
    {
        return self::NAME;
    }

    public function getValue()
    {
        // TODO: Implement getValue() method.
    }


}