<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Class SignUpForm
 * @package app\models
 */
class SignUpForm extends Model
{
    public $login;
    public $password;
    public $errors;

    private $user;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['login', 'password'], 'required'],
        ];
    }

    public function registerUser()
    {
        $user = new Users();
        $user->login = $this->login;
        $user->setPassword($this->password);
        $user->active = Users::STATUS_ACTIVE;

        if($user->validate())
        {
            $result = $user->save();
            $this->user = $user;
            return $result;
        }
        else
        {
            $this->errors = $user->getErrors();
            return false;
        }

    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->user, 3600*24*30);
        }

        return false;
    }
}
