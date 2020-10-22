<?php

class IndexController extends Controller
{
    public function __construct()
    {
        var_dump(__DIR__ . '/Views/layout.phtml');
        require_once(__DIR__ . '/Views/layout.phtml');
    }
}