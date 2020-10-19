<?php
require('../params/database.php');


$post = $_POST;


$birthdate = $post['year'] . "-"  . substr("0".$post['month'], -2) . "-" . substr("0".$post['day'], -2);

$database = new Database();
$sql = "UPDATE `users` SET `firstname` = ?, `lastname` = ?, `country` = ?, `birthdate` = STR_TO_DATE(?,'%Y-%m-%d')  WHERE `users`.`id` = ?";
$params = [
    // firstname
    $post['firstname'],
    //lastname
    $post['lastname'],
    //country
    $post['country'],
    //birthdate
    $birthdate,
    //userId
    $post['userId']
];

$save = $database->update($sql, $params);

var_dump($save);
$_SESSION['user']['userFirstname'] = $post['firstname'];
$_SESSION['user']['userLastname'] = $post['lastname'];

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
