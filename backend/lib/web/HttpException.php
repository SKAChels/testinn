<?php

declare(strict_types=1);

namespace app\lib\web;

class HttpException extends \yii\web\HttpException
{
    public array $extraInfo;
}