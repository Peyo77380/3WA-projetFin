<?php


abstract class Controller
{
    protected $display;
    protected $data;
    protected $postResult;
    protected $meta = [];
    protected string $target;

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

    public function setAdminFilter()
    {

        if (!isset($_SESSION['connectedUser']['role']) || ($_SESSION['connectedUser']['role'] !== 'teacher' && $_SESSION['connectedUser']['role'] !== 'admin')) {
            $_SESSION['error'] = "Vous n'avez pas les droits nécessaires pour visualiser cette page.";
            throw new Exception('notAllowed');
        }
    }

    public function setConnectedUserFilter()
    {

        if (!isset($_SESSION['connectedUser'])) {
            $_SESSION['error'] = "Vous devez vous connecter pour visualiser cette page.";
            throw new Exception('notAllowed');
        }
    }

}