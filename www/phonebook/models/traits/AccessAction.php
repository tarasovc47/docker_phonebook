<?php

namespace models\traits;

use system\core\App;

trait AccessAction
{
    public function checkAction($view) # функция проверки экшена, принимает аргументом вид
    {
        if (App::$components->session->isGuest() && !empty($this->authAction)) # если гостевая сессия, и есть разрешённые гостю экшены
        {
            foreach ($this->authAction as $action) # для каждого такого действия
            {
                $this->check($view, $action); # отправляем на проверку соответствия вида и экшена
            }
        }
        elseif (!empty($this->guestAction)) # если есть разрешённые гостю экшены
        {
            foreach ($this->guestAction as $action) {

                $this->check($view, $action); # то отправляем на проверку (не совсем понял, чем же они друг от друга отличаются)
            }
        }
    }
    public function check($view, $action)
    {
        if ($view == $action) # запрошенный экшен совпадает с видом
        {
            $referer = App::$components->request->referer; # вот тут вообще мало что понял
            return header("Location: {$referer}");
        }
    }
}