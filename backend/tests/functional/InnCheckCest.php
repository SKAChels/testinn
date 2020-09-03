<?php

declare(strict_types=1);

namespace app\tests\functional;

class InnCheckCest
{
    protected string $url = '/v1/inn/check';

    /**
     * Посылаем ИНН физического лица
     */
    public function sendPersonalInn(\FunctionalTester $I): void
    {
        $I->sendPOST($this->url, ['inn' => '222490425273']);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseEquals('false');
    }
}