<?php

class adminExercisesMadLibsController extends Controller
{
    public $sentences;


    public function __construct($target)
    {
        $exerciseName = 'MadLibs';

        require('./models/ExercisesModel.php');
        $connection = new ExercisesModel();
        $connection->setTableName($exerciseName);
        $connection->setQuery();
        $pdoResult = $connection->getSentences();

        $this->sentences = $pdoResult;
        parent::__construct($target, $this->sentences);
    }
}