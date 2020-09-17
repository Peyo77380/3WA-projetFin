<?php
require('../connect.php');
require ('../params/database.php');

var_dump($_POST);

$post = $_POST;

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
$params = [$post['username'], $post['email'], $post['password']];

$save = $database->saveToDb($sql, $params);

var_dump($save);
$_SESSION['user'] = [

    'userName' => $post['username'],
    'userId' => $save,
    'userMail' => $post['email']
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