<?php

require('../params/database.php');

$post = $_POST;

var_dump($post);
$exerciseId = $post['exerciseId'];
$databaseTable = $post['exerciseName'];

$sql = "DELETE FROM " . $databaseTable . " WHERE " . $databaseTable . ".`exerciseId` = ? ";

$param = [$exerciseId];

$data = new Database();
$data->update($sql, $param);

header('Location: ../adminExercisesUnorderedSentences.phtml');