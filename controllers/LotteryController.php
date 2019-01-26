<?php

namespace app\controllers;

use app\components\PrizeGenerator\Interfaces\Convertible;
use Yii;
use app\components\PrizeGenerator\Registry;
use app\components\PrizeGenerator\Start;
use app\models\LotteryChooseForm;
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
                        'actions' => ['index', 'play', 'answer', 'refuse'],
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

        try
        {
            $prize = $prizeGenerator->getStrategy();
        }
        catch (\Exception $e)
        {
            //Пишем в лог и кидаем на страницу извините ничо не выйграли
            $this->redirect('/site');
        }

        $model = new LotteryChooseForm();

        $model->value = $prize->getValue();
        $model->type = $prizeGenerator->getWonType();

        return $this->render('play', [
            'prizeName' => $prize->getName(),
            'prizeValue' => $prize->getValue(),
            'model' => $model,
            'isConvertible' => $prize instanceof Convertible
        ]);
    }

    /**
     * Получаем приз
     */
    public function actionAnswer()
    {
        $model = new LotteryChooseForm();

        if ($model->load(Yii::$app->request->post())) {

            $prizeStrategy = Registry::getObjectByType($model->type);

            switch ($model->action) {
                case 'take':
                    echo $model->action;
                case 'refuse':
                    $prizeStrategy->refuse();
                case 'convert':
                    echo $model->action;
                default:
                    //todo: тут можно обработать неверный кейс
                    break;
            }
        }
    }

    /**
     * Отказываемся от приза
     */
    public function actionRefuse()
    {
        return $this->render('refuse');
    }

    /**
     * Конвертируем приз
     */
    public function actionConvert()
    {
        echo "convert";
    }

}
