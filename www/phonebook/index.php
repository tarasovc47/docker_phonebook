<?php

use system\core\Autoloader;

try {
    ini_set('display_errors', 0);
    ini_set('file_uploads', 1);
    error_reporting(E_ALL);
    define('ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);
    require_once (ROOT . 'system/core/Autoloader.php');
    Autoloader::register();
} catch (Exception $e) {
    var_dump($e);
}

/*# единая точка входа
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); # избавляемся от аргументов, типа localhost/test?id=100500
$segments = explode('/', trim($uri, '/')); # разбиваем путь на сегменты

if ($segments[0] === 'auth') # если первый сегмент auth
{
    if ($segments[1] === 'signup') # а второй - регистрация
    {
        $file = 'auth/signup.php'; # подключаем страницу регистрации
    }
    elseif ($segments[1] === 'signin') # а второй - авторизация
    {
        $file = 'auth/signin.php'; # подключаем страничку авторизации
    }
    else $file = '404.php'; # иначе 404
}

else # если без /admin/
{
    if ($uri === '/') # то тут тоже простенький роутер
        $file = 'main.php';
    else $file = '404.php';
}

require 'views/' . $file; # подключаем полученный файл*/