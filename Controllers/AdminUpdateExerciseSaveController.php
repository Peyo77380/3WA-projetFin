<?php

require_once(__DIR__ . '/AdminExercisesController.php');

class AdminUpdateExerciseSaveController extends AdminExercisesController
{
    public function __construct($target)
    {
        $this->recievePostForm();

        $this->updateExercise();


        header('Location: /AdminExercises' . ucfirst($this->postResult['exerciseName']));

        $this->setTitle('Modification d\'exercice');
        $this->setDescription('Page de modification d\'un exercise existant.');
        $data = [];


        parent::__construct($target, $data, $this->meta);
    }

    public function updateExercise()
    {
        require_once('./models/ExercisesModel.php');

        $db = new ExercisesModel();
        $db->setId($this->postResult['exerciseId']);
        $db->setNewExercise($this->postResult['sentence']);
        $db->setTableName($this->postResult['exerciseName']);
        $db->setUpdateExerciseQuery();
        $db->launchDBRequest();
    }
}

