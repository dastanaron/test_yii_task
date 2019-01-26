<?php

namespace app\controllers;

use app\components\PrizeGenerator\Registry;
use app\components\PrizeGenerator\Start;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

/**
 * Class LotteryController
 * @package app\controllers
 */
class LotteryController extends \yii\web\Controller
{

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'play'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [

                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Начинаем играть и выбираем что делаем с призом
     * @return string
     */
    public function actionPlay()
    {
        $prizeGenerator = new Start();

        $prize = $prizeGenerator->getStrategy();

        VarDumper::dump($prize->getName(), 10, true);

        return $this->render('play', [
            'prizeName' => $prize->getName(),
            'prizeValue' => $prize->getValue(),
        ]);
    }

    /**
     * Получаем приз
     */
    public function actionTakePrize()
    {

    }

    /**
     * Отказываемся от приза
     */
    public function actionRefuse()
    {

    }

    /**
     * Конвертируем приз
     */
    public function actionConvert()
    {

    }

}
