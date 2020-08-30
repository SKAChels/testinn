<?php

declare(strict_types=1);

namespace app\components\api;

use app\components\ExceptionFactory;
use app\lib\web\HttpException;
use yii\base\InvalidConfigException;
use yii\httpclient\Response;
use yii\httpclient\Client;
use yii\httpclient\CurlTransport;
use yii\httpclient\Exception;

class TestInnStatusApiClient
{
    private const API_URL = 'https://statusnpd.nalog.ru/api/v1/tracker/taxpayer_status';
    private const REQUEST_TIMEOUT = 60;

    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'transport' => CurlTransport::class,
            'baseUrl' => self::API_URL,
            'requestConfig' => [
                'format' => Client::FORMAT_JSON,
            ],
            'responseConfig' => [
                'format' => Client::FORMAT_JSON,
            ],
        ]);
    }

    /**
     * @param string $inn
     * @return bool
     * @throws HttpException
     */
    public function isPersonalInnRequest(string $inn): bool
    {
        try {
            /** @var Response $response */
            $response = $this->client->createRequest()
                ->setMethod('POST')
                ->setData(['inn' => $inn, 'requestDate' => date('Y-m-d')])
                ->setOptions(['timeout' => self::REQUEST_TIMEOUT])
                ->send();

            $http_status = $response->getIsOk();
            $data = $response->getData();

        } catch (Exception | InvalidConfigException $e) {
            throw ExceptionFactory::innApiError();
        }

        if (!$http_status) {
            throw ExceptionFactory::innApiError($data);
        }

        return $data['status'];
    }
}