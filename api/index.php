<?php

use app\modules\api\controllers\MessageController;

require dirname(__DIR__) . '/vendor/autoload.php';

//$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
//$dotenv->load();

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'local');

//defined('YII_DEBUG') or define('YII_DEBUG', $_ENV['YII_DEBUG'] === 'true');
//defined('YII_ENV') or define('YII_ENV', $_ENV['YII_ENV']);

require dirname(__DIR__) . '/vendor/yiisoft/yii2/Yii.php';

$config = yii\helpers\ArrayHelper::merge(
    require dirname(__DIR__) . '/config/common.php',
    require dirname(__DIR__) . '/config/api.php'
);

$app = new yii\web\Application($config);

$controller = new MessageController('message', $app);
$response = $controller->runAction('index');

exit;

//(new yii\web\Application($config))->run();