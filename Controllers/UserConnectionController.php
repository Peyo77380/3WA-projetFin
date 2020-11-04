<?php

// gère la page d'inscription et de connection des utilisateurs.
class UserConnectionController extends Controller
{
    public function __construct($target)
    {
        $this->setTitle('Connection');
        $this->setDescription('Connection ou inscription des utilisateurs');
        parent::__construct($target);
    }
}
