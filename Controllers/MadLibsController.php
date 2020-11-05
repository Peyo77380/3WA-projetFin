<?php

// gère la partie élève des textes à trous
class MadLibsController extends Controller
{
    // texte complet, y compris les mots des trous, indiqués entre **
    public $madLibsText;

    // texte avec trous, indiqués par __
    public $madLibsExercise;

    // liste des mots correspondant aux trous, dans l'ordre d'apparition dans le texte
    public $madLibsWords;
    public $madLibsAnswerFields;
    public $display = [];

    public function __construct($target)


    {
        $this->setConnectedUserFilter('userConnection');
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

        parent::__construct($target, $this->display, $this->meta);


    }

    public function getExercise()
    {
        // va chercher les exercices en base de donnée
        $sentences = new ExercisesModel();
        $sentences->setTableName('madLibs');
        $sentences->setNumberOfSentences(3);
        $sentences->setGetterQuery();
        $pdoResult = $sentences->launchDBRequest();

        $cleanExercises = decodeArray($pdoResult);

        $this->madLibsText = $cleanExercises;

        $_SESSION['exercises']['text'] = $this->madLibsText;
    }

    public function setGapsAndWords()
    {
        // chaque exercice est mis en forme au moment de son enregistrement :
        // les mots destinés à être des trous dans l'affichage de l'exercie pour l'élève sont entourées de **
        foreach ($this->madLibsText as $exercise) {
            // les mots sont séparés au niveau des **
            $text = explode('**', $exercise['sentence']);

            // listes qui seront l'énoncé et les différents mots proposés.
            $content = [];
            $words = [];

            // les mots sont triés selon leur nature.
            for ($i = 0; $i < count($text); $i++) {
                if ($i % 2 == 0) {
                    $content[] = $text[$i];
                } else {
                    $words[] = $text[$i];
                }
            }

            // les mots et l'énoncé sont stockés pour servir plus tard
            // dans la vue ($this->madLibsExercise[$exercise['exerciseId']])
            // et dans la correction. ($_SESSION)
            $this->madLibsExercise[$exercise['exerciseId']] = $content;
            $_SESSION['exercises']['exercise'][$exercise['exerciseId']] = $content;
            $_SESSION['exercises']['words'][$exercise['exerciseId']] = $words;
            $this->madLibsWords[$exercise['exerciseId']] = $words;

        }
    }

    public function prepareForms()
    {
        // prépare les inputs nécessaires pour l'affichage de l'exercice.
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

            // mélange les mots disponibles
            $fillingWords = $this->madLibsWords[$id];
            shuffle($fillingWords);

            $this->display[$id]['fillingWords'] = ($fillingWords);
        }


    }

}
