<?php


abstract class Controller
{
    public $display;
    public $data;

    public function __construct($target, $data = [])
    {
        if ($target == "") {
            $target = "/index";
        }

        $this->getDedicatedView($target, $data);


    }

    protected function getDedicatedView($target, array $data = [])
    {


        $view = new Views($target);
        $this->display = $view->createTemplate($target, $data);

    }

    /*
    abstract protected function getModel($modelName)
    {
        //todo
    }
    */

}