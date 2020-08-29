<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/test_db.php';

/**
 * Application configuration shared by all test types
 */
$config = [
    'id' => 'testinn-tests',
    'basePath' => dirname(__DIR__),
    'language' => 'en-US',
    'components' => [
        'db' => $db,
    ],
    'params' => $params,
];

return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/web.php',
    $config
);
