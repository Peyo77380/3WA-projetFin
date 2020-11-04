<?php

// gère le formulaire de modication des exercices existants
require_once(__DIR__ . '/AdminExercisesController.php');

class AdminUpdateExerciseController extends AdminExercisesController
{
    public function __construct($target)
    {
        $this->setAdminFilter('userConnection');
        $this->recievePostForm();

        $this->setTitle('Modification d\'exercice');
        $this->setDescription('Page de modification d\'un exercise existant.');

        // prépare les infos pour le formulaire à afficher
        $exercise = [
            'exerciseName' => $this->postResult['exerciseName'],
            'exerciseId' => $this->postResult['exerciseId'],
            'exerciseContent' => decode($this->postResult['exerciseContent'])
        ];

        parent::__construct($target, $exercise);
    }


}
