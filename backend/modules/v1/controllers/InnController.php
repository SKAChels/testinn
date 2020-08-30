<?php

declare(strict_types=1);

namespace app\modules\v1\controllers;

use app\lib\web\HttpException;
use app\modules\v1\services\InnService;
use yii\rest\Controller;
use Yii;

class InnController extends Controller
{
    public InnService $innService;

    public function __construct($id, $module, InnService $innService, $config = [])
    {
        $this->innService = $innService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return bool
     * @throws HttpException
     */
    public function actionCheck(): bool
    {
        $data = Yii::$app->getRequest()->post();
        return $this->innService->isPersonalInn($data);
    }
}
