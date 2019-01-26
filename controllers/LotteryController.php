<?php

namespace app\controllers;

class LotteryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
