<?php

namespace app\components\PrizeGenerator\Interfaces;

/**
 * Interface Prizes
 * Интерфейс призов говорит о том, что любой приз можно получить, отказаться от него или запросить название категории приза
 * @package app\components\PrizeGenerator\Prizes
 */
interface Prizes
{
    public function take($value);

    public function calculate();

    public function refuse();

    public function getName();

    public function getValue();
}