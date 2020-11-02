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

        $_SESSION['error'] = [];

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

    public function checkEmptyField(array $requiredField, $origin)
    {
        $emptyFields = [];
        foreach ($requiredField as $name => $value) {
            if ($value == "") {
                $emptyFields[] = $name;
            }

        }

        if ($emptyFields !== []) {
            $message = 'Les champs suivants sont obligatoires : ';
            $message .= implode(',', $emptyFields);
            $message .= ".";
            throw new Exception (json_encode([
                'message' => $message,
                'origin' => $origin]));
        }
    }

    public function checkEmail(string $email)
    {

        if (!preg_match("/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/", $email)) {
            throw new Exception ('L\'adresse email n\'est pas valide');
        }
    }

    public function checkPassword(string $password)
    {


        if (!preg_match("/^(?=(?:.*[A-Z]))(?=(?:.*[a-z]))(?=(?:.*\d))(?=(?:.*[!@#$%^&*()\-_=+{};:,<.>]))(.{8,})$/", $password)) {
            throw new Exception ('Le mot de passe doit avoir au moins 8 caractères, dont une majuscule, une minuscule, un nombre.');

        }
    }
}