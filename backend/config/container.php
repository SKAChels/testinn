<?php

declare(strict_types=1);

use app\components\api\InnStatusClient;
use yii\httpclient\Client;
use yii\httpclient\CurlTransport;
use yii\caching\MemCache;
use yii\caching\CacheInterface;

return [
    'singletons' => [
        InnStatusClient::class => [
            'baseUrl' => 'https://statusnpd.nalog.ru/api/v1/tracker/taxpayer_status',
            'transport' => CurlTransport::class,
            'requestTimeout' => 60,
            'requestConfig' => [
                'format' => Client::FORMAT_JSON,
            ],
            'responseConfig' => [
                'format' => Client::FORMAT_JSON,
            ],
        ],
        CacheInterface::class => [
            'class' => MemCache::class,
            'useMemcached' => true,
            'servers' => [
                [
                    'host' => 'memcached',
                    'port' => getenv('MEMCACHED_PORT'),
                ],
            ],
        ]
    ],
];
