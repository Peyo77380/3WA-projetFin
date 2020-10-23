<?php


class AdminExercisesUnorderedSentencesController extends Controller
{
    public $sentences;


    public function __construct($target, $data = [])
    {
        require('./models/adminExercisesUnorderedSentencesModel.php');
        $data = new adminExercisesUnorderedSentencesModel();

        $data->setQuery();
        $pdoResult = $data->getSentences();


        $this->sentences = $pdoResult;

        parent::__construct($target, $this->sentences);
    }


}