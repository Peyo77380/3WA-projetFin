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
    public $display;
    public $note;
    public $correctionList;


    public function getAnswers()
    {

        $post = $_POST;
        $this->madLibsText = $_SESSION['exercises']['text'];
        $this->madLibsWords = $_SESSION['exercises']['words'];
        $this->madLibsExercise = $_SESSION['exercises']['exercise'];

        $words = [];
        foreach ($post as $word){
            $words[] = strtoupper($word);
        }

        $this->madLibsAnswers = $words;

    }

    public function setNote () {
        for ($i=0; $i<count($this->madLibsWords); $i++){

            if ($this->madLibsWords[$i] === $this->madLibsAnswers[$i]) {
                $this->note ++;

            } else {
                break;
            }
        }

        $this->note = $this->note . "/" . count($this->madLibsWords);
    }

    public function setCorrection () {
        $correction = [];

        for ($i=0; $i<count($this->madLibsWords); $i++){
            $correct = FALSE;
            if ($this->madLibsWords[$i] === $this->madLibsAnswers[$i]) {
                $correct = TRUE;
            }

            $correction[] = ['correctWord' => $this->madLibsWords[$i],
                            'answer' => $this->madLibsAnswers[$i],
                            'correction' => $correct
                ];
        }

        $this->correctionList = $correction;
    }

    public function clearSession () {
        unset($_SESSION['exercises']);
    }
}