<?php

namespace app\components\PrizeGenerator\Prizes;

use Yii;
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

    /**
     * @var
     */
    protected $params;

    /**
     * @var
     */
    protected $value;

    /**
     * @var BonusBills|null
     */
    protected $model;

    /**
     * BonusPoints constructor.
     */
    public function __construct()
    {
        $this->params = Registry::getParamsObject()->bonusPoints;

        $userId = \Yii::$app->user->identity->getId();
        $this->model = BonusBills::findOne(['user_id' => $userId]);
    }

    /**
     * Просто ищем счет пользователя и заносим на него бонусы
     * @param $value
     * @return bool
     */
    public function take($value)
    {
        $userId = Yii::$app->user->identity->getId();

        $userBonusBill = BonusBills::find()->where(['user_id' => $userId])->one();

        if(empty($userBonusBill))
        {
            $userBonusBill = new BonusBills();
            $userBonusBill->sum = 0;
            $userBonusBill->user_id = $userId;
        }

        $userBonusBill->sum += $value;

        return $userBonusBill->save();
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
     *
     */
    public function calculate()
    {
        $this->value = mt_rand($this->params->min, $this->params->max);
    }
}