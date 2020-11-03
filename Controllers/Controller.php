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

    public function recieveExercise()
    {
        $post = $_POST;
        $this->postResult = exercisesCleaner($post);

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

    public function setAdminFilter($origin)
    {

        if (!isset($_SESSION['connectedUser']['role']) || ($_SESSION['connectedUser']['role'] !== 'teacher' && $_SESSION['connectedUser']['role'] !== 'admin')) {
            $_SESSION['error'] = "";
            throw new Exception(
                [
                    'message' => 'notAllowedAdminRights',
                    'origin' => $origin,
                ]);
        }
    }

    public function setConnectedUserFilter()
    {

        if (!isset($_SESSION['connectedUser'])) {
            throw new Exception(
                [
                    'message' => 'notAllowed',
                    'origin' => $origin,
                ]
            );
        }
    }

    public function checkEmptyField(array $requiredField, $origin)
    {
        $emptyFields = [];
        foreach ($requiredField as $name => $value) {
            if ($value == "" || $value == "-") {
                $emptyFields[] = $name;
            }
        }

        if (count($emptyFields) !== 0) {

            throw new Exception (json_encode([
                'message' => 'emptyFields',
                'emptyFields' => $emptyFields,
                'origin' => $origin]));
        }
    }

}