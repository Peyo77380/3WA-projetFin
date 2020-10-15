<?php
require('./params/database.php');

$correction = new madLibsCorrectorController();
$correction->getAnswers();
$correction->setNote();
$correction->setCorrection();
$correction->clearSession();




class madLibsCorrectorController
{
    // texte complet, y compris les mots des trous, indiqués entre **
    public $madLibsText;

    // liste des mots correspondant aux trous, dans l'ordre d'apparition dans le texte
    public $madLibsWords;
    public $madLibsAnswers;
    public $madLibsExercise;
    public $note;
    public $correctionList;


    public function getAnswers()
    {

        $post = $_POST;


        $this->madLibsText = $_SESSION['exercises']['text'];
        $this->madLibsWords = $_SESSION['exercises']['words'];
        $this->madLibsExercise = $_SESSION['exercises']['exercise'];

        $words = [];
        foreach ($post as $index => $word) {


            $wordpos = strpos($index, 'word');
            $exerciseId = substr($index, 2, $wordpos - 2);

            $words[$exerciseId][] = $word;
        }

        $this->madLibsAnswers = $words;

    }

    public function setNote ()
    {
        $this->note = 0;
        $totalCount = 0;
        foreach ($this->madLibsWords as $exerciseId => $words) {
            $totalCount += count($this->madLibsWords[$exerciseId]);

            for ($i = 0; $i < count($words); $i++) {

                if ($words[$i] === $this->madLibsAnswers[$exerciseId][$i]) {
                    $this->note++;

                } else {
                    break;
                }
            }
        }

        $this->note = $this->note . "/" . $totalCount;
    }

    public function setCorrection ()
    {
        $correction = [];

        foreach ($this->madLibsWords as $exerciseId => $words) {

            for ($i = 0; $i < count($words); $i++) {
                $correctWord = $words[$i];
                $userAnswer = $this->madLibsAnswers[$exerciseId][$i];
                $correct = FALSE;
                if ($correctWord === $userAnswer) {
                    $correct = TRUE;
                }

                $correction[$exerciseId][] = [
                    'correctWord' => $correctWord,
                    'answer' => $userAnswer = $this->madLibsAnswers[$exerciseId][$i],
                    'correction' => $correct,
                ];
            }


        }

        $this->correctionList = $correction;
    }

    public function clearSession () {
        unset($_SESSION['exercises']);
    }
}