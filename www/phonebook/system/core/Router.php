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
        /** получаем строку запроса $uri */
        $uri = $this->getUri();
        /** проверяем наличие $uri в массиве путей routes.php */
        foreach ($this->_routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) /** если совпадение найдено */
            {
                $internalRoute = preg_replace("~{$uriPattern}~", $path, $uri); /** то заменяем его на найденное */
                if ($this->callAction($internalRoute)) /** и передаём в функцию */
                {
                    return true;
                }
            }
        }
        # если в роутах нет, пробуем найти урлу контроллер и экшн: /controllerName/actionName/params
        if ($this->callAction($uri)) {
            return true;
        }

        # если экшн не нашли, то покажем 404
        $controller = new Controller();
        return $controller->showError();
    }
    private function callAction($internalRoute)
    {
        $segments = explode("/", $internalRoute); /** разбиваем пришедший аргумент на сегменты */
        $controllerName = ucfirst(array_shift($segments) . 'Controller'); /** задаём имя контроллера по первой части урла */
        $actionName = 'action' . ucfirst(array_shift($segments)); /** и имя экшена по второй части урла */
        $parameters = $segments; /** всё остальное - в параметры */
        $className = '\controllers\\' . $controllerName; /** формируем имя класса по имени контроллера */
        if (class_exists($className)) /** вот это пока не работает, класс не инициализируется */
        {
            $controller = new $className();

            if (!method_exists($controller, $actionName) && $actionName == 'action')
            {
                $actionName = 'action' . ucfirst($controller->defaultAction);
            }
            if (method_exists($controller, $actionName))
            {
                call_user_func_array([$controller, $actionName], $parameters);
                return true;
            }
        }
        return false;
    }
}