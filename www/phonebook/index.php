<?php

use system\core\Autoloader;
use system\core\Router;

try {
    ini_set('display_errors', 0);
    ini_set('file_uploads', 1);
    error_reporting(E_ALL);
    define('ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);
    require_once (ROOT . 'system/core/Autoloader.php');
    Autoloader::register();
    Router::start();
} catch (Exception $e) {
    var_dump($e);
}