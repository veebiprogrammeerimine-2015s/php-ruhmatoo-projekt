<?php

require_once(__DIR__ . '../vendor/autoload.php');
//Kui app on kävitatud
define('APP_STARTED', true);

$app = new App\App();
$app->run($_REQUEST);
