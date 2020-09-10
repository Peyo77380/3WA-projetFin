<?php
require ('connect.php');
require ('./models/unorderedSentencesModel.php');




$exercise = new unorderedSentencesController();

$cutSentences = $exercise->sentenceCutter();

$unorderedSentences = $exercise->sentenceRandomizer();

$_SESSION['exercises']['unorderedSentences']['correct'] = $cutSentences;



class unorderedSentencesController
{
    public $sentences;
    public $cutSentences;
    public $unorderedSentences;

    public function __construct () {
        $sentences = new UnorderedSentencesModel();
        $sentences->setParams(5);
        $sentences->setQuery();
        $pdoResult = $sentences->getSentences();


        $this->sentences = $pdoResult;



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
            $shuffled = shuffle($ex['sentence']);

            $this->unorderedSentences[] = [
                'exerciseId' => $ex['exerciseId'],
                'sentence' => ($ex['sentence']),
            ];
        }

        return $this->unorderedSentences;
    }

    public function saveExercise ($a) {

    }



    public function correctUnorderedSentences () {
        $post = $_POST;
        $correctAnswers = $_SESSION['exercises']['unorderedSentences']['correct'];
        $userAnswers = [];
        $note = 0;

        foreach ($post as $answer) {

            $answer = explode(" ", $answer);
            $userAnswers[] = $answer;
        }


        foreach ($userAnswers as $key=>$value) {

            if ($value == $correctAnswers[$key]) {
                $note ++;
                $rating = 'Correct';
            } else {
                $rating = 'Faux';
            }

            $individualCheck =
                ['correctAnswer' => implode(" ", $correctAnswers[$key]),
                    'userAnswer' => implode(" ", $value),
                    'rating' => $rating
                ];

            $result['correction'][$key] = $individualCheck;

        }
        $result['note'] = $note . " / " . count($correctAnswers);
        return $result;

    }
}


