<?php
namespace system\core;

class Router
{
    private $_routes;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php'; # подключаем файл с путями
        $this->_routes = include ($routesPath);
    }

    /**
     * Возвращаем строку запроса
     * @return string|void
     */
    private function getUri()
    {
        if (!empty($_SERVER['REQUEST_URI']))
        {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }
    public function start()
    {
        # получаем строку запроса $uri
        $uri = $this->getUri();
        # проверяем наличие $uri в массиве путей routes.php
        foreach ($this->_routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) # если совпадение найдено
            {
                $segments = explode('/', $path); # разбиваем на массив
                $controllerName = ucfirst(array_shift($segments) . 'Controller'); # получаем имя контроллера
                $actionName = 'action' . ucfirst(array_shift($segments)); # получаем имя экшена
                $parameters = $segments; # остальное из урла передаём в параметры
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php'; # получаем файл контроллера
                if (file_exists($controllerFile))
                {
                    include_once ($controllerFile); # подключаем его
                }
                $controllerObject = new $controllerName; # создаём новый экземпляр конроллера
                $result = $controllerObject->$actionName(); # вызываем экшен
            }
        }
        if ($result != null) # если вызвалось - возвращаем true, таким образом цикл разрывается
        {
            return true;
        }
        # если экшн не нашли, то покажем 404
        $controller = new Controller();
        return $controller->showError();
    }
}