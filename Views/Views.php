<?php

class Views
{
    public $template;

    public function __constructor($request)
    {


    }

    public function createTemplate($request)
    {

        require_once($_SERVER['DOCUMENT_ROOT'] . '/3WA-projetFin/Views/layout.phtml');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/3WA-projetFin/Views' . $request . '.phtml');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/3WA-projetFin/Views/footer.php');


    }
}