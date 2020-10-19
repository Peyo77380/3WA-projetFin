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


$post = $_POST;

$newUser = postCleaner($post);

$data = new Database();
$sql = "UPDATE `users` SET `motherlanguage` = ?, `knownlanguages` = ? WHERE `users`.`id` = ?";

$knownLanguages = '';

if ($newUser['furtherLanguage1']) {
    $knownLanguages = $knownLanguages . $newUser['furtherLanguage1'];
    if (isset($newUser['furtherLanguage1Lvl'])) {
        $knownLanguages = $knownLanguages . "-" . $newUser['furtherLanguage1Lvl'] . "/";
    }
}

if ($newUser['furtherLanguage2']) {
    $knownLanguages = $knownLanguages . $newUser['furtherLanguage2'];
    if (isset($newUser['furtherLanguage2Lvl'])) {
        $knownLanguages = $knownLanguages . "-" . $newUser['furtherLanguage2Lvl'] . "/";
    }
}

if ($newUser['furtherLanguage3']) {
    $knownLanguages = $knownLanguages . $newUser['furtherLanguage3'];
    if (isset($newUser['furtherLanguage3Lvl'])) {
        $knownLanguages = $knownLanguages . "-" . $newUser['furtherLanguage3Lvl'] . "/";
    }
}



$params = [
    $newUser['motherLanguage'],
    $knownLanguages,
    $newUser['userId']
];

$save = $data->update($sql, $params);

header('Location: ../index.phtml');