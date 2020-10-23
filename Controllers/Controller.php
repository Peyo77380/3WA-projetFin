<?php


abstract class Controller
{
    public $display;
    public $data;
    public $postResult;

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

    public function recievePostForm()
    {
        $post = $_POST;
        $this->postResult = postCleaner($post);

    }


}