<?php
require('../tools/utilities.php');
require('../tools/database.php');

$post = $_POST;
$newUser = postCleaner($post);
/*
 *
 * 1ere etape
 * username
 * email
 * password
 * INSERT INTO users (`username`, `email`, `password`) VALUES ('test', 'test', 'test')
 */
$database = new Database();
$sql = 'INSERT INTO users (`username`, `email`, `password`, `role`) VALUES (?, ?, ?, "student")';
$params = [$newUser['username'], $newUser['email'], $newUser['password']];

$save = $database->saveToDb($sql, $params);

$_SESSION['user'] = [
    'userName' => $newUser['username'],
    'userId' => $save,
    'userMail' => $newUser['email']
];

header('Location: ../userSubscribe.phtml');


/*
 *
 * 2e etape
 * firstname
 * lastname
 * country
 * birthdate
 * UPDATE `users` SET `firstname` = 'test', `lastname` = 'test', `country` = 'test', `birthdate` = xx/Xx/xxxx  WHERE `users`.`id` = xx
 *
 */


/*
 *
 * 3e etape
 * langue maternelle
 * langues connues et niveau
 * UPDATE `users` SET `motherlanguage` = 'test', `knowlanguages` = 'test' WHERE `users`.`id` = xx
 *
 */