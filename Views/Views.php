<?php

class Views
{
    public $template;


    public function __constructor($request)
    {


    }

    public function createTemplate($request, $data, $meta)
    {
        $RequestedView = $_SERVER['DOCUMENT_ROOT'] . '/Views' . $request . '.phtml';
        //crée la vue en associant les éléments nécessaires.
        require_once($_SERVER['DOCUMENT_ROOT'] . '/Views/layout.phtml');

    }
}