<?php

require_once(__DIR__ . '/AdminExercisesController.php');

class adminDeleteExerciseController extends AdminExercisesController
{
    public function __construct($target)
    {
        $this->setAdminFilter('userConnection');
        $this->recievePostForm();

        $exerciseId = $this->postResult['exerciseId'];
        $databaseTable = $this->postResult['exerciseName'];

        require_once('./models/ExercisesModel.php');

        $data = new ExercisesModel();
        $data->setTableName($databaseTable);
        $data->setId($exerciseId);
        $data->setDeleteQuery();
        $data->launchDBRequest();


        header('Location: /AdminExercises' . ucfirst($databaseTable));

        parent::__construct($target);
    }
}
