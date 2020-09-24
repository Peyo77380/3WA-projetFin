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




switch ($databaseTable) {
    case 'unorderedSentences':

        header('Location: ../adminExercisesUnorderedSentences.phtml');
        break;

    case 'madLibs':

        header('Location: ../adminExercisesMadLibs.phtml');
        break;

    default:
        header('Location: ../index.phtml');
        break;
}