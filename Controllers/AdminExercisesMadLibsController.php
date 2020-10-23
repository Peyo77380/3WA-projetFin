<?php

class adminExercisesMadLibsController extends Controller
{
    public $sentences;


    public function __construct($target)
    {
        require('./models/adminExercisesMadLibsModel.php');
        $data = new adminExercisesMadLibsModel();

        $data->setQuery();
        $pdoResult = $data->getSentences();


        $this->sentences = $pdoResult;
        parent::__construct($target, $this->sentences);
    }
}