<?php
/** Переменные шаблона */
/* @var yii\web\View $this */
/* @var string $prizeName */
/* @var bool $isConvertible */
/* @var \app\models\LotteryChooseForm $model */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>
<h1>Congratulations! You won <?=$prizeName;?></h1>

<div class="col-sm-1"></div>
<div class="col-sm-10">
    <?php $form = ActiveForm::begin([
        'id' => 'choose-form',
        'layout' => 'horizontal',
        'action' => Url::to('/lottery/answer'),
    ]); ?>

    <?= $form->field($model, 'type')->hiddenInput()->label('') ?>

    <?= $form->field($model, 'value')->hiddenInput()->label('') ?>

    <?= Html::submitButton('Take', ['class' => 'btn btn-success', 'name' => 'LotteryChooseForm[action]', 'value' => 'take']) ?>
    <?= $isConvertible ? Html::submitButton('Convert', ['class' => 'btn btn-warning', 'name' => 'LotteryChooseForm[action]', 'value' => 'convert']) : '' ?>
    <?= Html::submitButton('Refuse', ['class' => 'btn btn-danger', 'name' => 'LotteryChooseForm[action]', 'value' => 'refuse']) ?>

    <?php ActiveForm::end(); ?>
</div>
<div class="col-sm-1"></div>
