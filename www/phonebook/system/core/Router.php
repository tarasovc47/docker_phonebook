<?php
namespace system\core;

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php'; # подключаем файл с путями
        $this->routes = include ($routesPath);
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
        /** получаем строку запроса $uri */
        $uri = $this->getUri();
        /** проверяем наличие $uri в массиве путей routes.php */
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri))
            {
                $segments = explode('/', $path);
                $controllerName = array_shift($segments) . 'Controller';
                $actionName = 'action' . ucfirst(array_shift($segments));
            }
            $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
            if (file_exists($controllerFile))
            {
                include_once ($controllerFile);
            }
            $controllerObject = new $controllerName;
            $result = $controllerObject->$actionName();
            if ($result != null)
            {
                break;
            }
        }
    }
}