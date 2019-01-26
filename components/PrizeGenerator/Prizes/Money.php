<?php

namespace app\components\PrizeGenerator\Prizes;

use app\components\PrizeGenerator\Interfaces\Convertible;
use app\components\PrizeGenerator\Interfaces\Prizes;
use app\components\PrizeGenerator\Traits\Refuse;

/**
 * Class Money
 * Реальные деньги, от которых можно отказаться, перевести на бонусный счет с учетом коэффициента, а так же получить
 * при этом нам нужно списать с призового счета компании и отправить в API банка
 * @package app\components\PrizeGenerator\Prizes
 */
class Money implements Prizes, Convertible
{
    use Refuse;

    const NAME = 'Money';

    public function convert()
    {
        // TODO: Implement convert() method.
    }

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