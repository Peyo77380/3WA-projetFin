<?php

class Router
{
    public function __construct()
    {
        $request = $_SERVER['REQUEST_URI'];

        switch ($request) {
            case '/' :
                require __DIR__ . '/index.phtml';
                break;
            case '' :
                require __DIR__ . '/index.phtml';
                break;
            case '/about' :
                require __DIR__ . '/about.phtml';
                break;
            default:
                http_response_code(404);
                // require __DIR__ . '/views/404.php';
                break;
        }

    }
}
