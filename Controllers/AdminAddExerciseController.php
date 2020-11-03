<?php

require_once(__DIR__ . '/AdminExercisesController.php');

class AdminAddExerciseController extends AdminExercisesController
{

    private $values;

    public function __construct($target)
    {
        $this->setAdminFilter('userConnection');
        $this->recievePostForm();
        $this->validateData();

        $this->exerciseName = $this->postResult['exerciseName'];
        $this->values = $this->postResult['newSentence'];

        $this->saveNewExercise();

        header('Location: /AdminExercises' . ucfirst($this->exerciseName));
        parent::__construct($target);
    }

    public function saveNewExercise()
    {
        require_once('./models/ExercisesModel.php');

        $data = new ExercisesModel();
        $data->setTableName($this->exerciseName);
        $data->setNewExercise($this->values);
        $data->setSaveQuery();
        $data->launchDBRequest();

    }

}