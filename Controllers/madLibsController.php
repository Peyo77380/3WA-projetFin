<?php
require('./params/database.php');


$madLibs = new madLibsController();
$madLibs->getExercise();
$madLibs->setGapsAndWords();
$madLibs->prepareForms();

class madLibsController
{
    // texte complet, y compris les mots des trous, indiqués entre **
    public $madLibsText;

    // texte avec trous, indiqués par __
    public $madLibsExercise;

    // liste des mots correspondant aux trous, dans l'ordre d'apparition dans le texte
    public $madLibsWords;
    public $madLibsAnswerFields;
    public $display;

    public function getExercise()
    {
        // remplacer par connection DBB
        $this->madLibsText =
            "Anna è una ragazza di Milano, lei è **ITALIANA**. Vive con la sua amica Susan, una ragazza **INGLESE** che 
            studia storia all'università. Anna e Susan sono due ragazze **EDUCATE**, **ESTROVERSE** e amano uscire con 
            gli amici. Luca è il fidanzato di Anna. Lui è un ragazzo **RISERVATO** e molto **ATLETICO**. Anna e 
            Luca sono una coppia **FELICE**. Loro sono sempre **ALLEGRI**.";

        $_SESSION['exercises']['text'] = $this->madLibsText;
    }

    public function setGapsAndWords()
    {
        $text = explode('**', $this->madLibsText);


        for ($i = 0; $i < count($text); $i++) {

            if ($i % 2 == 0) {
                $exercise[] = $text[$i];
            } else {
                $words[] = $text[$i];
            }
        }
        $this->madLibsExercise = $exercise;
        $_SESSION['exercises']['exercise'] = $exercise;
        $_SESSION['exercises']['words'] = $words;
        $this->madLibsWords = $words;

        return $words;
    }

    public function prepareForms()
    {
        for ($i = 0; $i < count($this->madLibsWords); $i++) {
            $answerField[] = "<input type='text' name='word" . $i . "' id='word" . $i . "'>";
        }

        for ($i = 0; $i < count($this->madLibsExercise); $i++) {
            $this->display[]  = $this->madLibsExercise[$i];
            if(isset($answerField[$i])) {
                $this->display[] = $answerField[$i];
            }
        }
    }

}