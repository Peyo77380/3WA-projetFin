<?php

require('../models/adminExercisesUnorderedSentencesModel.php');

$test = new AdminAddExercise();

$data = $test->saveNewExercise();
var_dump($data);



class AdminAddExercise
{
    public array $post;
    private $exerciseName;
    private $values;

    public function __construct ()
    {

        // prévoir function contre les injections SQL de Serge
        $this->post = $this->validateData($_POST);

        $this->exerciseName = $this->post['exerciseName'];
        $this->values = $this->post['newSentence'];

    }

    public function validateData ($element)
    {

        // pas de caractères spéciaux
        if (!isset($element)) {
            echo "Quelque chose ne s'est pas passé comme prévu. Merci de réessayer.";
            echo "Si le problème persiste, merci de contacter l'administrateur.";
            return;
        }
        foreach ($element as $key=>$value)
        {

            $cleanKey = htmlspecialchars($key);
            $cleanValue = htmlspecialchars($value /*, ENT_NOQUOTES*/);

            $this->post[$cleanKey] = $cleanValue;
        }

        foreach($this->post as $title => $value)
        {
            // pas de vide
            if ($value = "")
            {
                echo "Vous n'avez pas renseigné au moins une partie du formulaire";
                return;
            };

            // si une des valeurs ou un des titres contient < (&lt;) > (&gt;) ou & (&amp;), on obtient un message d'erreur.
            // " et ' (&#039) sont acceptés. (non convertis car encodage avec ENT_NOQUOTES)
            // les titres n'ont pas a contenir de caratères spéciaux, y compris " (&quot;) et ' (&#039, &apos);

            $forbiddenCharactersConvertion = ['&lt;', '&gt;', '&amp;', '&quot;', '&apos', '@'];

            foreach($forbiddenCharactersConvertion as $char)
            {
                if (strstr($title, $char) || strstr($value, $char))
                {
                    echo "Vous ne pouvez pas utiliser de caractères spéciaux";
                    return;
                }
            }

        }

        return $this->post;
    }

    public function saveNewExercise () {
        $conn = new Database();
        $conn->saveExercise($this->exerciseName, $this->values);
    }



}