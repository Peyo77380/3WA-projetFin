<?php

// gère la suppresion d'exercices de la base de données
require_once(__DIR__ . '/AdminExercisesController.php');

class AdminDeleteExerciseController extends AdminExercisesController
{
    public function __construct($target)
    {
        $this->setAdminFilter('userConnection');
        $this->recievePostForm();
        $this->validateData();
        $this->deleteInDb();

        header('Location: /3WA-projetFin/AdminExercises' . ucfirst($databaseTable));

        parent::__construct($target);
    }

}
