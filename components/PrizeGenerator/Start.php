<?php

namespace app\components\PrizeGenerator;

use app\components\PrizeGenerator\Interfaces\Prizes;
use app\components\PrizeGenerator\Prizes\BonusPoints;
use yii\web\ErrorHandler;

class Start
{

    /**
     * @var array
     */
    protected $params;

    /**
     * @var \stdClass
     */
    protected $prizesTypes;

    /**
     * @var int
     */
    protected $wonType;

    /**
     * Start constructor.
     */
    public function __construct()
    {
        $this->params = Registry::getParams();
        $this->prizesTypes = $this->params['prizesTypes'];
    }

    /**
     * Получаем класс стратегии приза
     * @return Prizes
     */
    public function getStrategy()
    {
        $this->wonType = $this->calcPrizeType();
        try
        {
            $class = Registry::getObjectByType($this->wonType);
        }
        catch (\Exception $e)
        {
            ErrorHandler::convertExceptionToError($e); //тут по идее логируем, но логеры я не ставил, поэтому выбрасываю просто выйгрыш бонусов
            return new BonusPoints();
        }

        return $class;
    }

    /**
     * Получаем выйгранную стратегию, чтобы получить параметры в шаблоне
     * @return int
     */
    public function getWonType()
    {
        return $this->wonType;
    }

    /**
     * Выбираем случайный тип
     * @return int
     */
    private function calcPrizeType()
    {
        $startType = 1;
        $endType = count($this->prizesTypes);

        return mt_rand($startType, $endType);
    }

}