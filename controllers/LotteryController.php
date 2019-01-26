<?php

namespace app\controllers;

use app\components\PrizeGenerator\Registry;
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

    public function actionPlay()
    {
        VarDumper::dump(Registry::getTypes(), 10, true);
    }

}
