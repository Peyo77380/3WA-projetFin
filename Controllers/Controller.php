<?php


abstract class Controller
{
    protected $display;
    protected $data;
    protected $postResult;
    protected $meta = [];

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

    public function setScript(string $scriptName)
    {
        $this->meta['scriptName'][] = $scriptName;
    }

    public function setTitle(string $title)
    {
        $this->meta['title'] = $title . " - Lasciatemi parlare";
    }

    public function setDescription(string $description)
    {
        $this->meta['description'] = $description;
    }

}