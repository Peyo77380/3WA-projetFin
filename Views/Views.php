<?php

class Views
{
    public $template;


    public function __constructor($request)
    {


    }

    public function createTemplate($request, $data, $meta)
    {
        var_dump($_SERVER);
        var_dump($_SERVER['DOCUMENT_ROOT']. '/3WA-projetFin/Views/layout.phtml');
        //crée la vue en associant les éléments nécessaires.
        $RequestedView = $_SERVER['DOCUMENT_ROOT'] . '/3WA-projetFin/Views'  . $request . '.phtml';
        require_once($_SERVER['DOCUMENT_ROOT']. '/3WA-projetFin/Views/layout.phtml');

    }
}