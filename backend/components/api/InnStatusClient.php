<?php

declare(strict_types=1);

namespace app\components\api;

use app\components\ExceptionFactory;
use app\lib\web\HttpException;
use yii\base\InvalidConfigException;
use yii\httpclient\Request;
use yii\httpclient\Response;
use yii\httpclient\Client;
use yii\httpclient\Exception;

class InnStatusClient extends Client
{
    public float $requestTimeout = 60;
    public string $inn;

    /**
     * @param string $inn
     * @return bool
     * @throws HttpException
     */
    public function isPersonalInnRequest(string $inn): bool
    {
        $this->inn = $inn;
        return $this->sendRequest();
    }

    /**
     * @return bool
     * @throws HttpException
     */
    private function sendRequest(): bool
    {
        try {
            $request = $this->buildRequest();
            $response = $request->send();

            $isPersonalInn = $this->handleResponse($response);

        } catch (Exception | InvalidConfigException $e) {
            throw ExceptionFactory::innApiError();
        }

        return $isPersonalInn;
    }

    /**
     * @param Response $response
     * @return bool
     * @throws Exception
     * @throws HttpException
     */
    private function handleResponse(Response $response): bool
    {
        $isOk = $response->getIsOk();
        $httpCode = (int) $response->getStatusCode();
        $data = $response->getData();

        if ($httpCode === 422) {
            throw ExceptionFactory::innApiError($data);
        }

        if (!$isOk) {
            throw ExceptionFactory::innApiError();
        }

        return $data['status'];
    }

    /**
     * @return mixed
     * @throws InvalidConfigException
     */
    private function buildRequest(): Request
    {
        return $this->createRequest()
            ->setMethod('POST')
            ->setData(['inn' => $this->inn, 'requestDate' => date('Y-m-d')])
            ->setOptions(['timeout' => $this->requestTimeout]);
    }
}