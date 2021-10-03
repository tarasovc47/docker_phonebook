<?php

namespace system\core;

class BaseObject
{
    public function __construct(array $properties = []) # при создании экземпляра принимается массив параметров, по умолчанию - пустой
    {
        foreach ($properties as $name => $value) {
            $this->$name = $value;
        }
    }

    public function __get($name)
    {
        if (method_exists($this, $name)) # если метод $name существует в классе BaseObject
        {
            return $this->$name(); # вызываем этот метод
        }
        elseif (method_exists($this, 'get' . ucfirst($name))) # если есть метод getName в классе BaseObject
        {
            $method = 'get' . ucfirst($name); # даём ему подобающее имя
            return $this->$method(); # и вызываем
        }
        throw new \Exception("Не найдено свойство {$this->getClass()}::\${$name}"); # генерим исключение
    }

    public function __set($name, $value)
    {
        throw new \Exception("Не найдено свойство {$this->getClass()}::\${$name}");
    }
    public function __call($name, $arguments)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method))
        {
            return $this->$method($arguments);
        }
        throw  new \Exception("Не найден метод {$this->getClass()}::\${$name}()");
    }

    public function getClass()
    {
        return get_class($this); # возвращает, если я всё правильно понял, всегда BaseObject
    }
}