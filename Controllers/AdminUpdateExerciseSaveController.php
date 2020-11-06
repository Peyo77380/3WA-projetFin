<?php

// gère la suppresion des exercices.
require_once(__DIR__ . '/AdminExercisesController.php');

class AdminUpdateExerciseSaveController extends AdminExercisesController
{
    public function __construct($target)
    {
        $this->setAdminFilter('userConnection');
        $this->recievePostForm();

        $this->updateExercise();


        header('Location: adminExercises' . ucfirst($this->postResult['exerciseName']));

        $this->setTitle('Modification d\'exercice');
        $this->setDescription('Page de modification d\'un exercise existant.');
        $data = [];


        parent::__construct($target, $data, $this->meta);
    }


}

