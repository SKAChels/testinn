<?php

declare(strict_types=1);

namespace app\modules\v1\services;

use app\components\ExceptionFactory;
use app\modules\v1\models\Inn;
use app\modules\v1\repository\InnRepository;

class InnService
{
    private InnRepository $repository;

    public function __construct(InnRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * @return bool
     * @throws \app\lib\web\HttpException
     */
    public function isPersonalInn(array $data): bool
    {
        $model = new Inn();
        $model->load($data);
        if(!$model->validate()) {
            throw ExceptionFactory::validationError($model->getErrors());
        }

        return true;
    }
}