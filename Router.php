<?php

// le controleur est lancé depuis l'index qui concentre toutes les redirections (cf .htaccess)
// il redirige vers les controlleurs et vues demandés.
// les modèles ne sont pour l'instant pas gérés dans le routeurs et doivent être appelés avec require_once() dans les fonctions des différents controllleurs, quand ils sont nécessaires.

class Router
{
    public $request;
    public $controllerName;

    public function __construct()
    {
        // récupère le nom du controlleur demandé.
        $this->defineRequest();

        if ($this->request === '' || $this->request === '/') {
            // si la demande ne contient pas de sous partie, ou que le site est lancé : l'index est appelé par défaut
            $this->request = '/index';
        }

        // la demande est récupérée et le controlleur nécessaire est demandé.
        try {
            $this->defineControllerName();

            $this->reroute();

        } catch (Exception $e) {
            // renvoie vers la vue de l'erreur 404 quand le controlleur et la vue demandés n'existent pas.
            http_response_code(404);
            require __DIR__ . '/Views/error/404.phtml';

        }

    }



    public function defineRequest()
    {
        // variable nécessaire car nous ne sommes pas à la racine du serveur.
        // elle est amenée à changer selon le serveur où les fichiers sont utilisés.
        $serverName = '3WA-projetFin/';

        $address = $_SERVER['REQUEST_URI'];
        $needle = '';
        // retourne le chemin vers le dossier Root du serveur
        $this->request = str_replace($serverName, $needle, $address);


    }

    public function defineControllerName()
    {
        //retourne le nom du controlleur nécessaire sous forme de string
        $this->controllerName = ucfirst(trim($this->request, '/')) . 'Controller';


    }

    public function reroute()
    {
        try {

            // lance les controleurs nécessaires à l'affichage de la page demandée
            if (
                file_exists(__DIR__ . '/Controllers/' . $this->controllerName . '.php') &&
                file_exists(__DIR__ . '/Views/Views.php') &&
                file_exists(__DIR__ . '/Controllers/Controller.php')
            ) {
                // controlleurs des classes abstraites principales
                require __DIR__ . '/Views/Views.php';
                require __DIR__ . '/Controllers/Controller.php';
                // controlleur de la classe correspondant à la page demandé.
                require_once(__DIR__ . '/Controllers/' . $this->controllerName . '.php');

                // crée une instance du controlleur demandé
                $requiredController = new $this->controllerName ($this->request);
            } else {
                // lance une exception si les controlleurs nécessaires n'existent pas.
                throw $e = new Exception();
            }

        } catch (Exception $e) {
            http_response_code(404);
            require __DIR__ . '/Views/error/404.phtml';

        }
    }
}
