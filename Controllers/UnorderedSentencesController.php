<?php







class unorderedSentencesController
{
    public $sentences;
    public $cutSentences;
    public $unorderedSentences;

    public function __construct()
    {
        require('./models/exerciseModel.php');

        $sentences = new Exercise();
        $sentences->setParams(5);
        $sentences->setQuery('unorderedSentences');
        $pdoResult = $sentences->getSentences();

        $cleanExercise = exercisesCleaner($pdoResult);

        $this->sentences = $cleanExercise;
        var_dump($this->sentences);
        $cutSentences = $this->sentences->sentenceCutter();

        $unorderedSentences = $this->sentences->sentenceRandomizer();


        $_SESSION['exercises']['unorderedSentences']['correct'] = $exercise->cutSentences;

    }

    public function sentenceCutter () {
        foreach($this->sentences as $ex) {
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


