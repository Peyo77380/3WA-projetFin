<?php


abstract class Controller
{
    public $display;
    public $data;
    public $postResult;
    public $meta = [];

    public function __construct($target, $data = [])
    {
        if ($target == "") {
            $target = "/index";
        }

        $this->getDedicatedView($target, $data, $this->meta);


    }

    protected function getDedicatedView($target, array $data = [], array $meta = [])
    {


        $view = new Views($target);
        $this->display = $view->createTemplate($target, $data, $meta);

    }

    public function recievePostForm()
    {
        $post = $_POST;
        $this->postResult = postCleaner($post);

    }

    public function setScript($scriptName)
    {
        $this->meta['scriptName'][] = $scriptName;
    }

    public function setTitle($title)
    {
        $this->meta['title'] = $title . " - Parliamo";
    }

}