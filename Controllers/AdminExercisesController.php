<?php

// classe abstraite servant à afficher les différentes pages administrations pour les exercices.
abstract class AdminExercisesController extends Controller
{

    public $exerciseName;
    public $values;
    public $sentences;
    
    public function __construct($target, $data)
    {


        parent::__construct($target, $data);
    }

    public function saveNewExercise()
    {
        // envoie l'exercice en base de donnée
        require_once('./models/ExercisesModel.php');

        $data = new ExercisesModel();
        $data->setTableName($this->exerciseName);
        $data->setNewExercise($this->values);
        $data->setSaveQuery();
        $data->launchDBRequest();

    }

    public function getSentences()
    {
        // récupère la liste des exercices existants en base de donnée
        require_once('./models/ExercisesModel.php');
        $connection = new ExercisesModel();
        $connection->setTableName($this->exerciseName);
        $connection->setGetterQuery();
        $pdoResult = $connection->launchDBRequest();
        
        $this->sentences = decodeArray($pdoResult);
    }

    public function updateExercise()
    {
        require_once('./models/ExercisesModel.php');

        $db = new ExercisesModel();
        $db->setId($this->postResult['exerciseId']);
        $db->setNewExercise($this->postResult['sentence']);
        $db->setTableName($this->postResult['exerciseName']);
        $db->setUpdateExerciseQuery();
        $db->launchDBRequest();
    }

    public function deleteInDb()
    {
        // supprime l'élément dans la base de donnée.
        $exerciseId = $this->postResult['exerciseId'];
        $databaseTable = $this->postResult['exerciseName'];

        require_once('./models/ExercisesModel.php');

        $data = new ExercisesModel();
        $data->setTableName($databaseTable);
        $data->setId($exerciseId);
        $data->setDeleteQuery();
        $data->launchDBRequest();

    }

    public function validateData()
    {
        // filtre avant l'envoi en DB les données pour les suppressions et ajouts d'exercices.
        if (!isset($this->postResult)) {
            echo "Quelque chose ne s'est pas passé comme prévu. Merci de réessayer.";
            echo "Si le problème persiste, merci de contacter l'administrateur.";
            return;
        }

        foreach ($this->postResult as $title => $value) {
            // pas de vide
            if ($value = "") {
                echo "Vous n'avez pas renseigné au moins une partie du formulaire";
                return;
            }

            // si une des valeurs ou un des titres contient < (&lt;) > (&gt;) ou & (&amp;), on obtient un message d'erreur.
            // " et ' (&#039) sont acceptés. (non convertis car encodage avec ENT_NOQUOTES)
            // les titres n'ont pas a contenir de caratères spéciaux, y compris " (&quot;) et ' (&#039, &apos);

            $forbiddenCharactersConvertion = ['&lt;', '&gt;', '&amp;', '&quot;', '&apos', '@'];

            foreach ($forbiddenCharactersConvertion as $char) {
                if (strstr($title, $char) || strstr($value, $char)) {
                    echo "Vous ne pouvez pas utiliser de caractères spéciaux";
                    return;
                }
            }

        }

        return $this->postResult;
    }
}