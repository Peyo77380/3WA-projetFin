<?php

function clean($string)
{
    return htmlspecialchars(htmlentities($string));
}

function postCleaner($post)
{
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
    foreach ($string as $wordNumber => $word) {
        $decodedWordNumber = html_entity_decode(htmlspecialchars_decode($wordNumber));
        $decodedWord = html_entity_decode(htmlspecialchars_decode($word));

        $decodedAnswer[$decodedWordNumber] = $decodedWord;
    }
}

function decodeArray($stringsArray)
{
    $decodedAnswer = [];
    foreach ($stringsArray as $id => $string) {

        foreach ($string as $wordNumber => $word) {
            $decodedWordNumber = html_entity_decode(htmlspecialchars_decode($wordNumber));
            $decodedWord = html_entity_decode(htmlspecialchars_decode($word));

            $decodedAnswer[$id][$decodedWordNumber] = $decodedWord;
        }
    }


    return $decodedAnswer;
}

