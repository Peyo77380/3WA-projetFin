<?php

abstract class AdminExercisesController extends Controller
{
    public $sentences;
    public $exerciseName;


    public function __construct($target)
    {
        require('./models/ExercisesModel.php');
        $connection = new ExercisesModel();
        $connection->setTableName($this->exerciseName);
        $connection->setQuery();
        $pdoResult = $connection->getSentences();

        $this->sentences = $pdoResult;
        parent::__construct($target, $this->sentences);
    }
}