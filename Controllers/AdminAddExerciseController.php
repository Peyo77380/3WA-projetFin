<?php

require_once(__DIR__ . '/AdminExercisesController.php');

class AdminAddExerciseController extends AdminExercisesController
{

    private $values;

    public function __construct($target)
    {

        $this->recievePostForm();
        $this->validateData();

        $this->exerciseName = $this->postResult['exerciseName'];
        $this->values = $this->postResult['newSentence'];

        $this->saveNewExercise();

        header('Location: /AdminExercises' . ucfirst($this->exerciseName));
        parent::__construct($target);
    }


    public function validateData()
    {

        // pas de caractères spéciaux
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

    public function saveNewExercise()
    {
        require_once('./models/ExercisesModel.php');

        $data = new ExercisesModel();
        $data->setTableName($this->exerciseName);
        $data->setNewExercise($this->values);
        $data->setSaveQuery();
        $data->launchDBRequest();

    }

}