<?php

class Views
{
    public $template;


    public function __constructor($request)
    {


    }

    public function createTemplate($request, $data, $meta)
    {


        //crée la vue en associant les éléments nécessaires.
        $RequestedView = str_replace('/', '', $request . '.phtml');
        require_once('layout.phtml');

    }
}