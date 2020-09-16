<?php
require('../params/database.php');

var_dump($_POST);

$post = $_POST;

$databaseTable = $post['exerciseName'];
$newValue = $post['exerciseContent'];
$exerciseId = $post['exerciseId'];

$data = new Database();

$sql = "UPDATE " . $databaseTable . " SET `sentence` = ? WHERE " .$databaseTable . ".`exerciseId` = ? ";
$params =[$newValue, $exerciseId];

$data->update($sql, $params);

header('Location: ../adminExercisesUnorderedSentences.phtml');