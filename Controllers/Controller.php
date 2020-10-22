<?php


abstract class Controller
{

    public function __construct($target)
    {


        $this->getDedicatedView($target);

    }

    protected function getDedicatedView($view)
    {
        include($_SERVER['DOCUMENT_ROOT'] . '/3WA-projetFin' . '/Views/layout.phtml');
        include($_SERVER['DOCUMENT_ROOT'] . '/3WA-projetFin' . '/Views' . $view . '.phtml');
        include($_SERVER['DOCUMENT_ROOT'] . '/3WA-projetFin' . '/Views/footer.php');
    }


}