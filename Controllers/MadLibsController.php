<?php


class MadLibsController extends Controller
{
    // texte complet, y compris les mots des trous, indiqués entre **
    public $madLibsText;

    // texte avec trous, indiqués par __
    public $madLibsExercise;

    // liste des mots correspondant aux trous, dans l'ordre d'apparition dans le texte
    public $madLibsWords;
    public $madLibsAnswerFields;
    public $display;

    public function __construct($target)

    {
        $this->setTitle('Texte à trous');
        $this->setDescription('Exercices de textes à trous en italien');
        $this->setScript('madLibs');
        $this->setScript('exerciseDisplay');
        $this->setScript('formValidation');


        require('./models/ExercisesModel.php');
        $_SESSION['exercises'] = [];

        $this->getExercise();
        $this->setGapsAndWords();
        $this->prepareForms();

        parent::__construct($target, $this->display);


    }

    public function getExercise()
    {
        $sentences = new ExercisesModel();
        $sentences->setTableName('MadLibs');
        $sentences->setNumberOfSentences(3);
        $sentences->setGetterQuery();
        $pdoResult = $sentences->launchDBRequest();

        $cleanExercises = decodeArray($pdoResult);

        $this->madLibsText = $cleanExercises;

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

            $fillingWords = $this->madLibsWords[$id];
            shuffle($fillingWords);

            $this->display[$id]['fillingWords'] = ($fillingWords);


        }


    }

}
