<?php

declare(strict_types=1);

use app\components\ErrorHandler;
use app\models\User;
use yii\web\JsonResponseFormatter;
use yii\caching\MemCache;
use yii\log\FileTarget;
use app\modules\v1\Module as ModuleApiV1;
use yii\web\JsonParser;
use yii\web\Response;

return [
    'id' => 'testinn-api',
    'name' => 'Test INN API',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'v1'],
    'components' => [
        'request' => [
            'enableCsrfValidation' => false,
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => JsonParser::class,
            ],
        ],
        'response' => [
            'format' => Response::FORMAT_JSON,
            'charset' => 'UTF-8',
            'formatters' => [
                Response::FORMAT_JSON => [
                    'class' => JsonResponseFormatter::class,
                    'prettyPrint' => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'errorHandler' => [
            'class' => ErrorHandler::class,
        ],
        'user' => [
            'identityClass' => User::class,
            'enableSession' => false,
        ],
        'cache' => [
            'class' => MemCache::class,
            'useMemcached' => true,
            'servers' => [
                [
                    'host' => 'memcached',
                    'port' => getenv('MEMCACHED_PORT'),
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                    'logVars' => ['_GET', '_POST'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
        ],
    ],
    'modules' => [
        'v1' => [
            'class' => ModuleApiV1::class,
        ],
    ]
];
