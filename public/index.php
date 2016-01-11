<?php

require_once(__DIR__ . '/../vendor/autoload.php');
//Kui app on kävitatud
//Kuvame erroreid
error_reporting(E_ALL);
ini_set('display_errors', 1);


$app = new App\App();
$app->run($_REQUEST);