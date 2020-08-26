<?php

declare(strict_types=1);

namespace app\modules\v1;

use Yii;
use yii\base\Module as BaseModule;

class Module extends BaseModule
{
    public function init(): void
    {
        parent::init();
        Yii::$app->urlManager->addRules(require __DIR__ . '/config/urlRules.php');
    }
}
