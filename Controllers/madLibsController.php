<?php
require('./models/unorderedSentencesModel.php');

$_SESSION['exercises'] = [];
$madLibs = new madLibsController();
$madLibs->getExercise();
$madLibs->setGapsAndWords();
$exercises = $madLibs->prepareForms();


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
        $sentences = new UnorderedSentencesModel();
        $sentences->setParams(3);
        $sentences->setQuery('madLibs');
        $pdoResult = $sentences->getSentences();


        $this->madLibsText = $pdoResult;

        $_SESSION['exercises']['text'] = $this->madLibsText;
    }

    public function setGapsAndWords()
    {

        foreach ($this->madLibsText as $exercise) {
            $text = explode('**', $exercise['sentence']);


            $content = [];
            $words = [];

            for ($i = 0; $i < count($text); $i++) {


                if ($i % 2 == 0) {
                    $content[] = $text[$i];
                } else {
                    $words[] = $text[$i];
                }
            }

            $this->madLibsExercise[$exercise['exerciseId']] = $content;
            $_SESSION['exercises']['exercise'][$exercise['exerciseId']] = $content;
            $_SESSION['exercises']['words'][$exercise['exerciseId']] = $words;
            $this->madLibsWords[$exercise['exerciseId']] = $words;

        }
    }

    public function prepareForms()
    {
        foreach ($this->madLibsText as $exercise) {

            $id = $exercise['exerciseId'];
            $answerField = [];

            for ($i = 0; $i < count($this->madLibsWords[$id]); $i++) {
                $answerField[] = "<input type='text' name='ex" . $id . "word" . $i . "' id='ex" . $id . "word" . $i . "'>";
            }


            for ($i = 0; $i < count($this->madLibsExercise[$id]); $i++) {
                $this->display[$id]['wording'][] = $this->madLibsExercise[$id][$i];
                if (isset($answerField[$i])) {
                    $this->display[$id]['wording'][] = $answerField[$i];
                }
            }

            $this->display[$id]['fillingWords'] = $this->madLibsWords[$id];


        }


    }

}