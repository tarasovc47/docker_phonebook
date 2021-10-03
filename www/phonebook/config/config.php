<?php

return [
    'components' => [
        'user' => \models\User::class,
        'test' => \models\Test::class,
        'test2' => \models\Test2::class,
        'test3' => [
            'test4' => \models\Test2::class,
            'test5' => \models\Test2::class,
        ],
    ]
];