<?php

namespace app\components;

use Exception;
use yii\helpers\Inflector;
use app\lib\web\HttpException;

class ExceptionFactory
{
    public const WRONG_RESPONSE = 1;
    public const VALIDATION_ERROR = 2;

    protected static array $MESSAGES = [
        self::WRONG_RESPONSE => 'Неверный ответ',
        self::VALIDATION_ERROR => 'Ошибка валидации',
    ];

    /**
     * @param $name
     * @param $args
     * @return HttpException
     */
    public static function __callStatic($name, $args)
    {
        $errorCode = constant(static::class . '::' . strtoupper(Inflector::underscore($name)));
        $prevException = isset($args[0]) && $args[0] instanceof Exception ? $args[0] : null;

        if ($errorCode === null) {
            return new HttpException(500, 'Invalid called exception: ' . $name, 0, $prevException);
        }

        return static::get($errorCode, $prevException);
    }

    public static function getMessage(int $code)
    {
        return static::$MESSAGES[$code];
    }

    /**
     * Создает класс исключения с нужным http-кодом и сообщением
     *
     * @param int $code
     * @param Exception $prevException
     * @return HttpException
     */
    public static function get(int $code = 0, Exception $prevException = null): HttpException
    {
        if (empty($details = static::getMessage($code))) {
            return new HttpException(500, 'Invalid exception code/message: ' . $code, $code, $prevException);
        }

        return new HttpException(400, $details, $code, $prevException);
    }

    /**
     * @param array $errors
     * @return HttpException
     */
    public static function validationError($errors = []): HttpException
    {
        $result = self::get(self::VALIDATION_ERROR);
        $result->extraInfo = $errors;

        return $result;
    }
}
