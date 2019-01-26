<?php

namespace app\components\PrizeGenerator;

use app\components\PrizeGenerator\Interfaces\Prizes;
use Yii;

/**
 * Class Registry
 * Класс регистрации компонента, со всем необходимым для него
 * @package app\components\prizeGenerator
 */
class Registry
{
    /**
     * @param $name
     * @return int
     */
    public static function getTypeByName($name)
    {
        return self::getParamsObject()->prizesTypes->$name;
    }

    /**
     * @param $type
     * Получаем класс стратегии по типу
     * @return Prizes
     */
    public static function getObjectByType($type)
    {
        foreach (self::getParams()['prizesTypes'] as $item) {
            if($item['type'] == $type)
            {
                return new $item['class']();
            }
        }
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
            $object->prizesTypes
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