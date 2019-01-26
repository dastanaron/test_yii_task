<?php
/** Переменные шаблона */
/* @var yii\web\View $this */
/* @var string $prizeName */
/* @var string $prizeValue */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<h1>Congratulations! You won <?=$prizeName;?></h1>

<div class="col-sm-4"></div>
<div class="col-sm-4">
    <?=Html::a('PLAY', Url::to(['/lottery/play']), ['class' => 'btn btn-success full-weight-btn']);?>
</div>
<div class="col-sm-4"></div>
