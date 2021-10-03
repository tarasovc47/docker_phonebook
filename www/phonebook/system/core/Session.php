<?php

namespace system\core;

class Session extends BaseObject
{
    public function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null; # возвращает массив с сессией с ключом $key при наличии
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value; # передаёт в массив сессии в элемент $key значение $value
    }

    public function getUser()
    {
        return $this->get('user');
    }

    public function isGuest()
    {
        return !$this->get('user');
    }

    public function login($userObject)
    {
        $this->set('user', $userObject);
    }

    public function logout()
    {
        if (isset($_SESSION['user']))
        {
            unset($_SESSION['user']);
        }
    }
}