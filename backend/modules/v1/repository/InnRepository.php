<?php

declare(strict_types=1);

namespace app\modules\v1\repository;

use app\components\api\TestInnStatusApiClient;
use yii\caching\CacheInterface;
use Yii;

class InnRepository
{
    private const CACHE_DURATION = 86400;

    private TestInnStatusApiClient $client;
    private CacheInterface $cache;

    public function __construct(TestInnStatusApiClient $client)
    {
        $this->client = $client;
        $this->cache = Yii::$app->cache;
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