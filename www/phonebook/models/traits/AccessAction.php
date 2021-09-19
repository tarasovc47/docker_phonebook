<?php

namespace models\traits;

use system\core\App;

trait AccessAction
{
    public function checkAction($view) # функция проверки экшена, принимает аргументом вид
    {
        if (App::$components->session->isGuest() && !empty($this->authAction)) # если гостевая сессия но он при этом пытается залогиниться
        {
            foreach ($this->authAction as $action) # для такого действия
            {
                $this->check($view, $action); # отправляем на проверку соответствия вида и экшена
            }
        }
        elseif (!empty($this->guestAction)) # если же сессия просто гостевая
        {
            foreach ($this->guestAction as $action) {
                $this->check($view, $action); # то отправляем на проверку (не совсем понял)
            }
        }
    }
    public function check($view, $action)
    {
        if ($view == $action) # если экшен совпадает с видом
        {
            $referer = App::$components->request-referer; # вот тут вообще мало что понял
            return header("Location: {$referer}");
        }
    }
}