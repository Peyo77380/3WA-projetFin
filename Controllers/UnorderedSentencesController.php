<?php

class unorderedSentencesController extends Controller
{
    public $sentences;
    public $cutSentences;
    public $unorderedSentences;

    public function __construct($target)
    {
        $this->setConnectedUserFilter('userConnection');
        $this->setTitle('Phrases déstructurées');
        $this->setDescription('Exercices de phrases destructurées en italien');
        $this->setScript('exerciseDisplay');
        $this->setScript('unorderedSentences');
        $this->setScript('formValidation');

        require('./models/ExercisesModel.php');

        $_SESSION['exercises'] = [];

        $this->getExercise();
        $this->sentenceCutter();
        $this->sentenceRandomizer();


        $_SESSION['exercises']['unorderedSentences']['correct'] = $this->cutSentences;

        parent::__construct($target, $this->unorderedSentences);

    }

    public function getExercise()
    {
        $sentences = new ExercisesModel();
        $sentences->setTableName('UnorderedSentences');
        $sentences->setNumberOfSentences(3);
        $sentences->setGetterQuery();
        $pdoResult = $sentences->launchDBRequest();

        $cleanExercises = decodeArray($pdoResult);

        $this->sentences = $cleanExercises;

        $_SESSION['exercises']['text'] = $this->sentences;
    }

    public function sentenceCutter()
    {
        foreach ($this->sentences as $ex) {
            $sentence = explode(" ", $ex['sentence']);

            $this->cutSentences[] = [
                'exerciseId' => $ex['exerciseId'],
                'sentence' => $sentence,
            ];
        }

        return $this->cutSentences;
    }

    public function sentenceRandomizer () {

        foreach($this->cutSentences as $ex){
            shuffle($ex['sentence']);

            $this->unorderedSentences[] = [
                'exerciseId' => $ex['exerciseId'],
                'sentence' => ($ex['sentence']),
            ];
        }

        return $this->unorderedSentences;
    }



}


