<?php


var_dump($_POST);

$post = $_POST;
$update = postCleaner($post);

$databaseTable = $update['exerciseName'];
$newValue = $update['exerciseContent'];
$exerciseId = $update['exerciseId'];

$data = new Database();

$sql = "UPDATE " . $databaseTable . " SET `sentence` = ? WHERE " . $databaseTable . ".`exerciseId` = ? ";
$params = [$newValue, $exerciseId];

$data->update($sql, $params);

header('Location: ../adminExercisesUnorderedSentences.phtml');