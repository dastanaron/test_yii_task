<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LotteryChooseForm extends Model
{
    public $type;
    public $value;
    public $action;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['type', 'value', 'action'], 'required'],
        ];
    }
}
