<?php
ini_set('display_errors', 1);
define('APP_PATH', dirname(__DIR__));

require_once APP_PATH . '/vendor/autoload.php';

use App\Kernel\App;

$app = new App();

$app->run();

phpinfo();

