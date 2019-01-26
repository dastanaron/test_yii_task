<?php

namespace app\components\PrizeGenerator\Traits;

use Yii;
use yii\helpers\Url;

trait Refuse
{

    /**
     * @return \yii\console\Response|\yii\web\Response
     */
    public function refuse()
    {
        return Yii::$app->response->redirect(['lottery/refuse'])->send();
    }

}