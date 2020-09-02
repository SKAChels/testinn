<?php

declare(strict_types=1);

namespace app\modules\v1\services;

use app\components\ExceptionFactory;
use app\lib\web\HttpException;
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
     * @throws HttpException
     */
    public function isPersonalInn(array $data): bool
    {
        $inn = new Inn();
        if(!$inn->load($data) || !$inn->validate()) {
            throw ExceptionFactory::validationError($inn->getErrorSummary(true));
        }

        return $this->repository->isPersonalInn($inn->getInn());
    }
}