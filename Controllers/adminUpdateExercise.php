<?php

$post = $_POST;
$exerciseTranslation = '';
$exerciseContent = $post['exerciseContent'];
$exerciseId = $post['exerciseId'];

if(!isset($post['exerciseName']))
{
    throw new Exception('Pas de nom d\'exercice');
}
if($post['exerciseName'] == 'unorderedSentences')
{
    $exerciseTranslation = 'Phrases déstructurées';
}


return $display = [
    'dbTableName' => $post['exerciseName'],
    'name' => $exerciseTranslation,
    'content' => $exerciseContent,
    'id' => $exerciseId
];