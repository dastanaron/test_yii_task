<?php

return [
    'adminEmail' => 'admin@example.com',

    //Настройки для генератора призов, можно перенести в базу, чтобы с админки управлять, но так как нет админки, будет здесь
    'prizeGenerator' => [

        //Типы призов регистрируем тут
        'prizesTypes' => [
            'money' => [
                'class' => 'app\components\PrizeGenerator\Prizes\Money',
                'type' => 1,
            ],
            'bonusPoints' => [
                'class' => 'app\components\PrizeGenerator\Prizes\BonusPoints',
                'type' => 2,
            ],
            'item' => [
                'class' => 'app\components\PrizeGenerator\Prizes\Item',
                'type' => 3,
            ]
        ],

        //настройка получения бонусных баллов
        'bonusPoints' => [
            'min' => 100,
            'max' => 1000,
        ],
        //Настройка выйгрыша реальных денег
        'money' => [
            'min' => 10,
            'max' => 100,
        ],
        //Коэффициент конвертирования реальных денег в бонусы просто умножить на это число
        'convertCoefficient' => 10,
    ],
];
