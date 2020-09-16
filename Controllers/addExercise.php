<?php
require('../params/database.php');

var_dump($_POST);

$post = $_POST;

$databaseTable = $post['exerciseName'];
$sentence = $post['newSentence'];

$sql = "INSERT INTO " . $databaseTable . " (`exerciseId`, `sentence`) VALUES (NULL, ?);";
$params = [$sentence];

$data = new Database();
$data->update($sql, $params);

header('Location: ../adminExercisesUnorderedSentences.phtml');