<?php


abstract class Controller
{
    public $display;

    public function __construct($target)
    {
        if ($target == "") {
            $target = "/index";
        }

        $this->getDedicatedView($target);


    }

    protected function getDedicatedView($target)
    {


        $view = new Views($target);
        $this->display = $view->createTemplate($target);

    }

    abstract protected function getModel($modelName)
    {
        //todo
    }


}