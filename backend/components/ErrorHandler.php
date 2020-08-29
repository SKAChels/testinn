<?php

declare(strict_types=1);

namespace app\components;

use app\lib\web\HttpException;
use Yii;
use yii\base\ErrorException;
use yii\base\ErrorHandler as YiiErrorHandler;
use yii\base\Exception;
use yii\web\Response;

class ErrorHandler extends YiiErrorHandler
{
    protected function convertExceptionToArray($exception, $debug = false): array
    {
        $array = [
            'name' => ($exception instanceof Exception || $exception instanceof ErrorException)
                ? $exception->getName()
                : 'Exception',
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'type' => get_class($exception),
        ];

        if ($exception instanceof HttpException) {
            $array['status'] = $exception->statusCode;
        }

        $array = array_merge($array, (isset($exception->extraInfo) ? ['extra' => $exception->extraInfo] : []));

        if ($debug) {
            $array['file'] = $exception->getFile();
            $array['line'] = $exception->getLine();
            $array['stack-trace'] = explode("\n", $exception->getTraceAsString());

            if ($exception instanceof HttpException && $exception->requestData) {
                $array['_REQUEST_DATA'] = $exception->requestData;
            }
        }

        if (($prev = $exception->getPrevious()) !== null) {
            $array['previous'] = $this->convertExceptionToArray($prev, $debug);
        }

        /** @var HttpException $exception */
        return $array;
    }

    protected function renderException($exception): void
    {
        if (Yii::$app->has('response')) {
            $response = Yii::$app->getResponse();

            $response->isSent  = false;
            $response->stream  = null;
            $response->data    = null;
            $response->content = null;
        } else {
            $response = new Response();
        }

        $response->setStatusCodeByException($exception);
        $response->data = $this->convertExceptionToArray($exception, false);
        $this->dumpToLog(
            $this->convertExceptionToArray($exception, true),
            is_writable('/dev/console') ? '/dev/console' : 'php://stderr'
        );

        $response->send();
    }

    protected function dumpToLog(array $data, string $file): void
    {
        $data['_URL']  = Yii::$app->getRequest()->getAbsoluteUrl();
        $data['_GET']  = Yii::$app->getRequest()->get();
        $data['_POST'] = Yii::$app->getRequest()->post();

        file_put_contents($file, json_encode($data, JSON_THROW_ON_ERROR, 512) . "\n");
    }
}