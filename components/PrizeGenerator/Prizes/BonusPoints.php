<?php

namespace app\components\PrizeGenerator\Prizes;

use app\components\PrizeGenerator\Interfaces\Prizes;
use app\components\PrizeGenerator\Registry;
use app\components\PrizeGenerator\Traits\Refuse;
use app\models\BonusBills;

/**
 * Class BonusPoints
 * Бонусы на счет, стратегия позволяет отказаться от них или получить и зачислить на бонусный счет
 * @package app\components\PrizeGenerator\Prizes
 */
class BonusPoints implements Prizes
{
    use Refuse;

    const NAME = 'Bonus points';

    protected $params;

    protected $value;

    protected $model;

    public function __construct()
    {
        $this->params = Registry::getParamsObject()->bonusPoints;

        $userId = \Yii::$app->user->identity->getId();
        $this->model = BonusBills::findOne(['user_id' => $userId]);

        $this->calculate();
    }

    public function take()
    {
        // TODO: Implement take() method.
    }

    public function getName()
    {
        return $this->getValue() . ' ' . self::NAME;
    }

    public function getValue()
    {
        return $this->value;
    }

    protected function calculate()
    {
        $this->value = mt_rand($this->params->min, $this->params->max);
    }


}