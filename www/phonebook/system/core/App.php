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
        session_start(); # стартуется либо возобновляется сессия
        $app = new self;
        $app->_config = $config; # передаём параметр $config в приватный конфиг приложения
        $app->setApp();
    }

    private function setApp()
    {
        $components = $this->getComponents(); # передаём результат выполнения функции в $components
        $this->$components = (object) $components; #
        return true;
    }

    private function getComponents()
    {
        $components = []; # задаём, что это пустой массив
        if (!empty($this->_config['components'])) # если массив с компонентами не пустой
        {
            foreach ((array) $this->_config['components'] as $componentName => $params) { # для каждого компонента
                $class = !is_array($params) ? new $params : null; # создаём экземпляр компонента, который по сути класс, если $params не массив
                if (!$class) # если класс не создался или создался пустой
                {
                    $className = array_shift($params); # передаём первый элемент компонента в "имя класса"
                    $class = new $className(); # инициируем класс
                    foreach ($params as $name => $value)
                    {
                        $class->$name = $value;
                    }
                }
                $components[$componentName] = $class;
            }
        }
        return $components;
    }
}