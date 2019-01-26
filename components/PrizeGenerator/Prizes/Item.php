<?php

namespace app\components\PrizeGenerator\Prizes;

use app\components\PrizeGenerator\Interfaces\Prizes;
use app\components\PrizeGenerator\Traits\Refuse;
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
     * @var array|PrizeItems[]
     */
    protected $items;

    protected $value;

    protected $name;

    public function __construct()
    {
        $this->items = PrizeItems::find()->where(['>','count', 0])->all();
        $this->calculate();
    }

    public function take()
    {
        // TODO: Implement take() method.
    }

    public function getName()
    {
        return "item: " . $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    private function calculate()
    {
        if(empty($this->items))
        {
            throw new \Exception('not enough money');
        }

        $countElements = count($this->items);

        $randomElementNumber = mt_rand(0, $countElements-1);

        $this->value = $this->items[$randomElementNumber]->id;

        $this->name = $this->items[$randomElementNumber]->name;
    }


}