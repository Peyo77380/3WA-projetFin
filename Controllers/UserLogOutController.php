<?php

// detruit toute la session en cours et renvoie à l'index.
class UserLogOutController extends Controller
{
    public function __construct($target)
    {
        session_destroy();

        header('Location: /3WA-projetFin/');
        
        
        die();
        
        parent::__construct($target, $data);

    }
}
