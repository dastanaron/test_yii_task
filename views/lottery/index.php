<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
?>
<h1>Just today. One of three prizes;</h1>

<p>
    Just click on the button and get a prize.
</p>

<div class="col-sm-4"></div>
<div class="col-sm-4">
    <?=Html::a('PLAY', Url::to(['/lottery/play']), ['class' => 'btn btn-success full-weight-btn']);?>
</div>
<div class="col-sm-4"></div>
