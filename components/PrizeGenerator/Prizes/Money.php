<?php

namespace app\components\PrizeGenerator\Prizes;

use app\models\BonusBills;
use Yii;
use app\components\BankTransactions\Robokassa;
use app\components\PrizeGenerator\Interfaces\Convertible;
use app\components\PrizeGenerator\Interfaces\Prizes;
use app\components\PrizeGenerator\Registry;
use app\components\PrizeGenerator\Traits\Refuse;
use app\models\FirmBills;

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
     * Здесь все просто, деньги со счета компании не списываем, так как
     * это бонусный баланс, и мы можем сэкономить на сумме. Ну если надо списать, то можно и списать
     * Затем мы перемножаем на коэффициент конвертации и прибавляем к текущей сумме бонусного баланса.
     * Если счета нет, то заводим, хотя такие вещи хорошо бы заводить при регистрации
     * @param $value
     * @return bool
     */
    public function convert($value)
    {
        $coefficient = Registry::getParamsObject()->convertCoefficient;

        $userId = Yii::$app->user->identity->getId();

        $userBonusBill = BonusBills::find()->where(['user_id' => $userId])->one();

        if(empty($userBonusBill))
        {
            $userBonusBill = new BonusBills();
            $userBonusBill->sum = 0;
            $userBonusBill->user_id = $userId;
        }

        $convertMoneyToBonus = $value * $coefficient;

        $userBonusBill->sum += $convertMoneyToBonus;

        return $userBonusBill->save();
    }

    /**
     * Тут мы отнимаем сумму и отправляем ее клиенту, списывая у фирмы
     * По хорошему нужно еще писать табличку кому и сколько мы перевели, но я уже устал
     * @param $value
     * @return bool
     */
    public function take($value)
    {
        $currentSum = $this->model->total_sum;
        $this->model->total_sum = $currentSum - $value;
        $saveFirmSum = $this->model->save();

        $bank = new Robokassa(Yii::$app->user->identity->getId());
        $resultTransactionToClient = $bank->sendMoneyToClient($value);

        return $saveFirmSum && $resultTransactionToClient;
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
    public function calculate()
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