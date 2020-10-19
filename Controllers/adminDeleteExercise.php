<?php

require('../params/database.php');

$post = $_POST;
$delete = postCleaner($post);


$exerciseId = $delete['exerciseId'];
$databaseTable = $delete['exerciseName'];

$sql = "DELETE FROM " . $databaseTable . " WHERE " . $databaseTable . ".`exerciseId` = ? ";

$param = [$exerciseId];

$data = new Database();
$data->update($sql, $param);

header('Location: ../adminExercisesUnorderedSentences.phtml');