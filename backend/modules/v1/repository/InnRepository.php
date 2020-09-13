<?php

declare(strict_types=1);

namespace app\modules\v1\repository;

use app\components\api\InnStatusClient;
use yii\caching\CacheInterface;

class InnRepository
{
    private const CACHE_DURATION = 86400;

    private CacheInterface $cache;
    private InnStatusClient $client;

    public function __construct(CacheInterface $cache, InnStatusClient $client)
    {
        $this->cache = $cache;
        $this->client = $client;
    }

    public function isPersonalInn(string $inn): bool
    {
        $data = $this->cache->getOrSet(
            $inn,
            fn() => ['isPersonalInn' => $this->client->isPersonalInnRequest($inn)],
            self::CACHE_DURATION
        );

        return $data['isPersonalInn'];
    }
}