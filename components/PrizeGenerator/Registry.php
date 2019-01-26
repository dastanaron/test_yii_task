<?php

namespace app\components\PrizeGenerator;

use Yii;

/**
 * Class Registry
 * Класс регистрации компонента, со всем необходимым для него
 * @package app\components\prizeGenerator
 */
class Registry
{
    const TYPE_MONEY_PRIZE = 1;
    const TYPE_BONUS_POINTS_PRIZE = 2;
    const TYPE_ITEM_PRIZE = 3;

    /**
     * @return array
     * @throws \ReflectionException
     */
    public static function getTypes()
    {
        $reflection = new \ReflectionClass(__CLASS__);
        return $reflection->getConstants();
    }

    /**
     * @return array
     */
    public static function getParams()
    {
        return Yii::$app->params['prizeGenerator'];
    }

    /**
     * Собирает удобный объект
     * @example
            Структура объекта
            $object->bonusPoints->min $object->bonusPoints->max
            $object->money->min $object->bonusPoints->max
            $object->convertCoefficient
     * @param null $params
     * @return \stdClass
     */
    public static function getParamsObject($params = null)
    {

        if(empty($params))
        {
            $params = self::getParams();
        }

        $object = new \stdClass();

        foreach($params as $paramName => $param) {

            if(is_array($param)) {
                $object->$paramName = self::getParamsObject($param);
            }
            else
            {
                $object->$paramName = $param;
            }
        }

        return $object;

    }

}