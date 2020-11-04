<?php


// gère l'ajout de nouveaux exercices dans la base de donnée
require_once(__DIR__ . '/AdminExercisesController.php');

class AdminAddExerciseController extends AdminExercisesController
{

    private $values;

    public function __construct($target)
    {
        $this->setAdminFilter('userConnection');
        $this->recievePostForm();


        $this->exerciseName = $this->postResult['exerciseName'];
        $this->values = $this->postResult['newSentence'];

        $this->saveNewExercise();

        header('Location: /AdminExercises' . ucfirst($this->exerciseName));
        parent::__construct($target);
    }

    public function saveNewExercise()
    {
        // envoie l'exercice en base de donnée
        require_once('./models/ExercisesModel.php');

        $data = new ExercisesModel();
        $data->setTableName($this->exerciseName);
        $data->setNewExercise($this->values);
        $data->setSaveQuery();
        $data->launchDBRequest();

    }

}