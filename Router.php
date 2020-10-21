<?php

class Router
{
    public $request;
    public $globalRoute;
    public $research;

    public function __construct()
    {

        $this->defineRequest();

        $view;

        if ($this->request === '' || $this->request === '/') {
            require __DIR__ . '/Controllers/Controller.php';
            require __DIR__ . '/Controllers/indexController.php';
            $view = new Index();

        } else {
            try {
                $controllerName = $this->setTarget();

                require __DIR__ . '/Controllers/Controller.php';
                require_once($_SERVER['DOCUMENT_ROOT'] . $this->route . 'Controllers/' . $controllerName . '.php');

                $requiredController = new $controllerName ($this->research);
            } catch (Exception $e) {
                http_response_code(404);
                require __DIR__ . '/Views/404.php';

            }

        }


    }

    public function defineRequest()
    {
        $serverName = '/3WA-projetFin';
        $this->request = str_replace($serverName, '', $_SERVER['REQUEST_URI']);
    }

    public function setTarget()
    {

        $this->research = substr($_SERVER['REQUEST_URI'],
            strpos($_SERVER['REQUEST_URI'],
                '/',
                1),
            strlen($_SERVER['REQUEST_URI']));
        $controllerName = ucfirst(trim($this->research, '/')) . 'Controller';

        $this->route = substr_replace($_SERVER['REQUEST_URI'], "", strpos($_SERVER['REQUEST_URI'], $this->research)) . "/";

        return $controllerName;
    }
}
