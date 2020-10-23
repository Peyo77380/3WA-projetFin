<?php

class Router
{
    public $request;
    public $globalRoute;
    public $research;
    public $controllerName;

    public function __construct()
    {

        $this->defineRequest();

        $view;

        if ($this->request === '' || $this->request === '/') {

            /*
            require(__DIR__ . '/Controllers/Controller.php');
            require_once(__DIR__ . '/Controllers/IndexController.php');

            $requiredController = new IndexController ();
*/
            $this->controllerName = 'IndexController';
            $this->reroute($this->controllerName);

        } else {
            try {
                $controllerName = $this->defineControllerName();

                $this->reroute($controllerName);

            } catch (Exception $e) {
                http_response_code(404);
                require __DIR__ . '/Views/404.php';

            }

        }


    }

    public function defineRequest()
    {

        $serverName = '3WA-projetFin/';
        $this->request = str_replace($serverName, '', $_SERVER['REQUEST_URI']);

        $this->globalRoute =
            substr_replace(
                $_SERVER['REQUEST_URI'],
                "",
                strpos(
                    $_SERVER['REQUEST_URI'],
                    $this->research)
            ) . "/" . $serverName;
    }

    public function defineControllerName()
    {

        $this->research = substr($_SERVER['REQUEST_URI'],
            strpos($_SERVER['REQUEST_URI'],
                "/",
                1),
            strlen($_SERVER['REQUEST_URI']));
        $this->controllerName = ucfirst(trim($this->research, '/')) . 'Controller';


    }

    public function reroute()
    {
        try {


            if (file_exists(__DIR__ . '/Controllers/' . $this->controllerName . '.php')) {
                require __DIR__ . '/Views/Views.php';
                require __DIR__ . '/Controllers/Controller.php';

                require_once(__DIR__ . '/Controllers/' . $this->controllerName . '.php');

                $requiredController = new $this->controllerName ($this->research);
            } else {
                throw $e = new Exception();
            }

        } catch (Exception $e) {
            http_response_code(404);
            require __DIR__ . '/Views/404.php';

        }
    }
}
