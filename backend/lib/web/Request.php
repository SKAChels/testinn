<?php

namespace app\lib\web;

use Yii;
use yii\base\ExitException;
use yii\helpers\Inflector;
use yii\web\NotFoundHttpException;
use yii\web\Request as YiiWebRequest;

class Request extends YiiWebRequest
{
    /**
     * @return array
     * @throws ExitException
     * @throws NotFoundHttpException
     */
    public function resolve(): array
    {
        // OPTIONS FIX
        if ($this->getIsOptions() && $this->headers->has('Access-Control-Request-Method')) {
            Yii::$app->getResponse()->statusCode = 200;

            throw new ExitException();
        }

        return parent::resolve();
    }
}
