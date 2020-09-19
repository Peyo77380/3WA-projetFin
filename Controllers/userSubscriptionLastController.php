<?php

require('../params/database.php');



/*
 *
 * 3e etape
 * langue maternelle
 * langues connues et niveau
 * UPDATE `users` SET `motherlanguage` = 'test', `knowlanguages` = 'test' WHERE `users`.`id` = xx
 *
 */

var_dump($_POST);
$post = $_POST;

$data = new Database();
$sql = "UPDATE `users` SET `motherlanguage` = ?, `knownlanguages` = ? WHERE `users`.`id` = ?";

$knownLanguages = '';

if($post['furtherLanguage1']) {
    $knownLanguages = $knownLanguages. $post['furtherLanguage1'];
    if(isset($post['furtherLanguage1Lvl'])){
        $knownLanguages = $knownLanguages . "-" . $post['furtherLanguage1Lvl'] . "/";
    }
}

if($post['furtherLanguage2']) {
    $knownLanguages = $knownLanguages. $post['furtherLanguage2'];
    if(isset($post['furtherLanguage2Lvl'])){
        $knownLanguages = $knownLanguages . "-" . $post['furtherLanguage2Lvl'] . "/";
    }
}

if($post['furtherLanguage3']) {
    $knownLanguages = $knownLanguages. $post['furtherLanguage3'];
    if(isset($post['furtherLanguage3Lvl'])){
        $knownLanguages = $knownLanguages . "-" . $post['furtherLanguage3Lvl'] . "/";
    }
}



$params = [
    $post['motherLanguage'],
    $knownLanguages,
    $post['userId']
];

$save = $data->update($sql, $params);

header('Location: ../index.phtml');