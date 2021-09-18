<?php
namespace system\core;

class Router
{
    public static function start()
    {
        # единая точка входа
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

        require 'views/' . $file; # подключаем полученный файл
    }
}