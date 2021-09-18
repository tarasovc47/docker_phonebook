<?php
namespace system\core;

class App
{
    /**
     * @var object компоненты приложения
     */
    public static $components;
    /**
     * @var массив с конфигурацией
     */
    private $_config;
    public static function start($config)
    {
        $app = new self;
        var_dump($config);
    }
}