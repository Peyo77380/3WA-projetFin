<?php

class Index extends Controller
{
    public function __construct()
    {
        var_dump($_SERVER);
        require_once($_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI'] . 'Views/layout.phtml');
    }
}