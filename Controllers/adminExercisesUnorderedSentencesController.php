<?php
require('./models/adminExercisesUnorderedSentencesModel.php');

$admin = new adminExercisesUnorderedSentencesController();



class adminExercisesUnorderedSentencesController
{
    public $sentences;

    public function __construct()
    {
        $data = new adminExercisesUnorderedSentencesModel();

        $data->setQuery();
        $pdoResult = $data->getSentences();


        $this->sentences = $pdoResult;

    }
}