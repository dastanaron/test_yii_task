<?php

namespace app\components\PrizeGenerator\Prizes;

use app\components\PrizeGenerator\Interfaces\Convertible;
use app\components\PrizeGenerator\Interfaces\Prizes;
use app\components\PrizeGenerator\Registry;
use app\components\PrizeGenerator\Traits\Refuse;
use app\models\FirmBills;
use yii\helpers\VarDumper;

/**
 * Class Money
 * Реальные деньги, от которых можно отказаться, перевести на бонусный счет с учетом коэффициента, а так же получить
 * при этом нам нужно списать с призового счета компании и отправить в API банка
 * @package app\components\PrizeGenerator\Prizes
 */
class Money implements Prizes, Convertible
{
    use Refuse;

    /**
     *
     */
    const NAME = 'Money';

    /**
     * @var \stdClass min max
     */
    protected $params;

    /**
     * @var
     */
    protected $value;

    /**
     * @var FirmBills|null
     */
    protected $model;

    /**
     * Money constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->params = Registry::getParamsObject()->money;

        $this->model = FirmBills::findOne(['type' => 1]);

        $this->calculate();
    }

    /**
     *
     */
    public function convert()
    {
        // TODO: Implement convert() method.
    }

    /**
     *
     */
    public function take()
    {
        // TODO: Implement take() method.
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getValue() . ' ' . self::NAME;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @throws \Exception
     */
    protected function calculate()
    {
        $value = mt_rand($this->params->min, $this->params->max);

        if($this->model->total_sum >= $value)
        {
            $this->value = $value;
        }
        else
        {
            throw new \Exception('not enough money');
        }
    }


}