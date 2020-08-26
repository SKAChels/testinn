<?php

declare(strict_types=1);

use yii\rest\UrlRule;

return [
    [
        'class' => UrlRule::class,
        'controller' => ['v1/inn'],
        'pluralize' => false,
    ],
];
