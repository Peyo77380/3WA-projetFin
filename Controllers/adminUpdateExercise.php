<?php

$post = $_POST;
var_dump($post);
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
if($post['exerciseName'] == 'madLibs')
{
    $exerciseTranslation = 'Texte à trous';
}


return $display = [
    'dbTableName' => $post['exerciseName'],
    'name' => $exerciseTranslation,
    'content' => $exerciseContent,
    'id' => $exerciseId
];