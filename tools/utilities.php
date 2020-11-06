<?php

function clean($string)
{
    // filtre les caractères spéciaux
    return htmlspecialchars(htmlentities($string));
}

function postCleaner($post)
{
    // filtre les caractères spéciaux sur tous les champs d'un POST.
    $rebuildPost = [];

    foreach ($post as $key => $value) {
        $cleanValue = clean($value);
        $cleanKey = clean($key);

        $rebuildPost[$cleanKey] = $cleanValue;

    }

    return $rebuildPost;

}

function exercisesCleaner($exercises)
{
    // filtre les caractères spéciaux sur tous les champs d'un POST (moins sur que postCleaner()
    $rebuiltExercises = [];
    foreach ($exercises as $exerciseId => $exercise) {
        foreach ($exercise as $key => $value) {
            $cleanValue = htmlspecialchars($value);
            $cleanKey = htmlspecialchars($key);

            $rebuiltExercises[$exerciseId][$cleanKey] = $cleanValue;
        }
    }

    return $rebuiltExercises;
}

function decode($string)
{
    // permet de décoder les champs passés par la fonction  clean()
    return filter_var(htmlspecialchars_decode(html_entity_decode($string)), FILTER_SANITIZE_STRING);


}

function decodeArray($stringsArray)
{
    // permet de décoder une liste passéee par postCleaner ou stockée dans la BD
    $decodedAnswer = [];
    foreach ($stringsArray as $id => $string) {

        foreach ($string as $wordNumber => $word) {
            $decodedWordNumber = filter_var(html_entity_decode(htmlspecialchars_decode($wordNumber)), FILTER_SANITIZE_STRING);
            $decodedWord = filter_var(html_entity_decode(htmlspecialchars_decode($word)), FILTER_SANITIZE_STRING);

            $decodedAnswer[$id][$decodedWordNumber] = $decodedWord;
        }
    }

    return $decodedAnswer;
}

