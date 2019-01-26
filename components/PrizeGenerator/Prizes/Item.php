<?php

namespace app\components\PrizeGenerator\Prizes;

use Yii;
use app\components\PrizeGenerator\Interfaces\Prizes;
use app\components\PrizeGenerator\Traits\Refuse;
use app\models\PrizeDelivery;
use app\models\PrizeItems;
use yii\helpers\VarDumper;

/**
 * Class Item
 * Предмет. Стратегия должна искать предмет в базе данных, по списку присутствующих, т.е. count > 0, позволяет отказаться
 * или получить, в таком случае нам нужно зарегистрировать заказ в prize_delivery
 * @package app\components\PrizeGenerator\Prizes
 */
class Item implements Prizes
{
    use Refuse;

    /**
     * @var
     */
    protected $value;

    /**
     * @var
     */
    protected $name;

    /**
     * Item constructor.
     * В этой стратегии не пригодился
     */
    public function __construct()
    {

    }

    /**
     * В этой стратегии, нам в качестве value приходит id предмета
     * Поэтому ищем прдмет, отнимаем 1 и сохраняем. Так же делаем запись в таблицу доставки
     * @param $value
     * @return bool
     */
    public function take($value)
    {
        $item = PrizeItems::findOne(['id' => $value]);
        $item->count -= 1;

        $minusItem = $item->save();

        $userId = Yii::$app->user->identity->getId();

        $delivery = new PrizeDelivery();
        $delivery->count = 1;
        $delivery->prize_item_id = $value;
        $delivery->user_id = $userId;

        $sentToDelivery = $delivery->save();

        return $minusItem && $sentToDelivery;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "item: " . $this->name;
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
        $items = PrizeItems::find()->where(['>','count', 0])->all();

        if(empty($items))
        {
            throw new \Exception('not enough money');
        }

        $countElements = count($items);

        $randomElementNumber = mt_rand(0, $countElements-1);

        $this->value = $items[$randomElementNumber]->id;

        $this->name = $items[$randomElementNumber]->name;
    }
}