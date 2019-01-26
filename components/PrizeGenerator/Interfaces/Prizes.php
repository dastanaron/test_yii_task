<?php

namespace app\components\PrizeGenerator\Interfaces;

/**
 * Interface Prizes
 * Интерфейс призов говорит о том, что любой приз можно получить, отказаться от него
 * @package app\components\PrizeGenerator\Prizes
 */
interface Prizes
{
    public function take();

    public function refuse();

}