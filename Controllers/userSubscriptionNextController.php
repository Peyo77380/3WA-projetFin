<?php
require('../params/database.php');


$post = $_POST;
$newUser = postCleaner($post)

$birthdate = $newUser['year'] . "-" . substr("0" . $newUser['month'], -2) . "-" . substr("0" . $newUser['day'], -2);

$database = new Database();
$sql = "UPDATE `users` SET `firstname` = ?, `lastname` = ?, `country` = ?, `birthdate` = STR_TO_DATE(?,'%Y-%m-%d')  WHERE `users`.`id` = ?";
$params = [
    // firstname
    $newUser['firstname'],
    //lastname
    $newUser['lastname'],
    //country
    $newUser['country'],
    //birthdate
    $birthdate,
    //userId
    $newUser['userId']
];

$save = $database->update($sql, $params);

$_SESSION['user']['userFirstname'] = $newUser['firstname'];
$_SESSION['user']['userLastname'] = $newUser['lastname'];

header('Location: ../userSubscribeLast.phtml');


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
