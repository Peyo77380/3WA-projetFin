<?php
require('./models/adminExercisesMadLibsModel.php');

$admin = new adminExercisesMadLibsController();


class adminExercisesMadLibsController
{
        public $sentences;

        public function __construct()
    {
        $data = new adminExercisesMadLibsModel();

        $data->setQuery();
        $pdoResult = $data->getSentences();


        $this->sentences = $pdoResult;

    }

}