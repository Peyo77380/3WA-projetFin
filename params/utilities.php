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