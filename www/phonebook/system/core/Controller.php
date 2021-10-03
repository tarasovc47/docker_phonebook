<?php

namespace system\core;

use models\traits\AccessAction;

/** базовый класс контроллер */
class Controller
{
    use AccessAction;

    /** @var string путь к видам */
    const VIEW_FOLDER = 'views/';
    /** @var string путь к шаблонам */
    const LAYOUT_FOLDER = 'views/layouts/';

    /** @var string дефолтный экшен */
    public $defaultAction = 'index';
    /** @var array  экшены, куда можно только авторизованным юзерам */
    public $authAction = [];
    /** @var array  экшены, куда можно только гостям */
    public $guestAction = [];
    /** @var string дефолтный шаблон */
    protected $layout = 'main';

    /** @var string представление */
    private $_view;
    /** @var array данные для представления */
    private $_data;

    /**
     * 404
     * @param string $message
     * @return mixed
     */
    public function showError(string $message = null, $exit = false)
    {
        $this->render('404', compact('message'));
        if ($exit)
        {
            exit();
        }
    }

    /**
     * Возвращает представление с шаблонами
     * @param string $view
     * @param array $data
     * @return mixed
     */
    public function render($view, array $data = [])
    {
        $this->checkAction($view);
        $this->_view = $view;
        $this->_data = $data;
        require self::VIEW_FOLDER . $view . '.php';
        return $this->getLayout();
    }

    /**
     * Возвращение видов без шаблонов
     * @param string $view путь к виду
     * @param array $data массив данных для вида
     * @return false|string
     */
    public function renderPartial(string $view, array $data)
    {
        $this->checkAction($view);
        $this->_view = $view;
        $this->_data = $data;
        echo $this->getContent();
    }

    /**
     * Перенаправление на указанный экшен
     * @param string $view
     */
    public function redirect($view)
    {
        $this->checkAction($view);
        return header("Location: {$view}");
    }

    /**
     * Возвращает контент, представление
     * @return false|string
     */
    protected function getContent()
    {
        ob_start(); # включение буферизации вывода
        $this->getView();
        return ob_get_clean(); # очищаем буфер вывода и отключаем его
    }

    /**
     * Подключаем css
     * @param string $templatePath путь до файла
     * @return string
     */
    public function registerCssFile($templatePath)
    {
        echo "<link href='{$templatePath}' rel='stylesheet'>";
    }

    /**
     * Подключаем js
     * @param string $templatePath путь до файла
     * @return string
     */
    public function registerJsFile($templatePath)
    {
        echo "<script src='{$templatePath}' type='text/javascript'></script>";
    }

    /**
     * Отрисовка вида
     * @return mixed
     */
    private function getView()
    {
        extract($this->_data);

        return require $this->getViewFolder() . "/{$this->_view}.php";
    }

    /**
     * возвращаем папку с видами дочерних контроллеров
     * @return string
     */
    private function getViewFolder()
    {
        $dir = $this->_view == 'error' ? null : $this->getChildClassName(); # Если текущего видо нет, то возвращаем null, иначе -
        return ROOT . self::VIEW_FOLDER . $dir;
    }

    /**
     * Отрисовываем шаблон
     * @return mixed
     */
    private function getLayout()
    {
        return require ROOT . self::LAYOUT_FOLDER . $this->layout . '.php';
    }

    /**
     * Возвращает имя дочернего контроллера
     * @return string
     */
    private function getChildClassName()
    {
        return strtolower(str_replace(['controllers\\', 'Controller', 'system\core\\'], '', get_class($this)));
    }
}