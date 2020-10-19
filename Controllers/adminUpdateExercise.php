<?php

require('../params/database.php');


$post = validateData($_POST);


$exerciseName = $post['exerciseName'];
$values = $post['id'];

$conn  = new Database();
$sentence = $conn->getOne('SELECT * FROM '.$exerciseName.' WHERE id = ?', $values);







function validateData($element)
{

    // pas de caractères spéciaux
    if (!isset($element)) {
        echo "Quelque chose ne s'est pas passé comme prévu. Merci de réessayer.";
        echo "Si le problème persiste, merci de contacter l'administrateur.";
        return;
    }
    foreach ($element as $key => $value) {

        $cleanKey = htmlspecialchars($key);
        $cleanValue = htmlspecialchars($value /*, ENT_NOQUOTES*/);

        $post[$cleanKey] = $cleanValue;
    }

    foreach ($post as $title => $value) {
        // pas de vide
        if ($value = "") {
            echo "Vous n'avez pas renseigné au moins une partie du formulaire";
            return;
        }

        // si une des valeurs ou un des titres contient < (&lt;) > (&gt;) ou & (&amp;), on obtient un message d'erreur.
        // " et ' (&#039) sont acceptés. (non convertis car encodage avec ENT_NOQUOTES)
        // les titres n'ont pas a contenir de caratères spéciaux, y compris " (&quot;) et ' (&#039, &apos);

        $forbiddenCharactersConversion = ['&lt;', '&gt;', '&amp;', '&quot;', '&apos', '@'];

        foreach ($forbiddenCharactersConversion as $char) {
            if (strstr($title, $char) || strstr($value, $char)) {
                echo "Vous ne pouvez pas utiliser de caractères spéciaux";
                return;
            }
        }

    }

    return $post;
}

$post = $_POST;
$update = postCleaner($post);

$exerciseTranslation = '';
$exerciseContent = $post['exerciseContent'];
$exerciseId = $post['exerciseId'];

if (!isset($post['exerciseName'])) {
    throw new Exception('Pas de nom d\'exercice');
}
if ($post['exerciseName'] == 'unorderedSentences')
{
    $exerciseTranslation = 'Phrases déstructurées';
}
if($post['exerciseName'] == 'madLibs')
{
    $exerciseTranslation = 'Texte à trous';
}


return $display = [
    'dbTableName' => $post['exerciseName'],
    'name' => $exerciseTranslation,
    'content' => $exerciseContent,
    'id' => $exerciseId
];

