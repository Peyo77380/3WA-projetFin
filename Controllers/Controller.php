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
        // si pas d'url spéciale : redirection vers l'index
        if ($target == "") {
            $target = "/index";
        }

        // lance la vue nécessaire, en fonction de l'url transmise par le router.
        $this->getDedicatedView($target, $data, $this->meta);

        $_SESSION['error'] = [];

    }

    // lance la vue nécessaire, en fonction de l'url transmise par le router.
    protected function getDedicatedView($target, array $data = [], array $meta = [])
    {
        
        try {

            $view = new Views($target);
            $this->display = $view->createTemplate($target, $data, $meta);
        } catch (Exception $e) {
            throw new Exception('erreur chargement vue');

        }

    }

    // filtre les posts pour éviter les scripts
    public function recievePostForm()
    {
        $post = $_POST;
        $this->postResult = postCleaner($post);

    }

    // filtre les posts pour éviter les scripts (moins sécurisé que recievePostForms()
    public function recieveExercise()
    {
        $post = $_POST;
        $this->postResult = exercisesCleaner($post);

    }

    // indique le nom du script js nécessaire pour le renvoyer dans le layout
    public function setScript(string $scriptName)
    {
        $this->meta['scriptName'][] = $scriptName;
    }

    // indique le nom de la page pour le renvoyer dans le layout
    public function setTitle(string $title)
    {
        $this->meta['title'] = $title . " - Lasciatemi parlare";
    }

    // indique la description de la page pour le renvoyer dans le layout
    public function setDescription(string $description)
    {
        $this->meta['description'] = $description;
    }

    // si le filtre est appliqué sur un controlleur : l'utilisateur doit avoir le role de "teacher" ou de "admin" pour
    // pouvoir afficher la page liée, sinon il est redirigé vers la connection.
    public function setAdminFilter($origin)
    {

        if (!isset($_SESSION['connectedUser']['role']) || ($_SESSION['connectedUser']['role'] !== 'teacher' && $_SESSION['connectedUser']['role'] !== 'admin')) {
            $_SESSION['error'] = "";
            throw new Exception(json_encode(
                [
                    'message' => 'notAllowedAdminRights',
                    'origin' => $origin,
                ]));
        }
    }

    // si le filtre est appliqué sur un controlleur : l'utilisateur doit être connecté
    // pouvoir afficher la page liée, sinon il est redirigé vers la connection.
    public function setConnectedUserFilter($origin)
    {

        if (!isset($_SESSION['connectedUser'])) {
            throw new Exception(json_encode(
                [
                    'message' => 'notAllowed',
                    'origin' => $origin,
                ]
            ));
        }
    }

    // permet de vérifier les champs vides dans un formulaire (sous forme de liste dans $requireField)
    // s'il y a un champ vide : redirection vers la page correspndant à l'url dans $origin
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