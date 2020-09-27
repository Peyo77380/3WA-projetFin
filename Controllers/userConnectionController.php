<?php
require('../connect.php');
require('../params/database.php');

$post = $_POST;

$data = new Database();

$sql = "SELECT * FROM `users` WHERE `users`.`username` = ?";
$params = [$post['username']];

$user = $data->getSingleData($sql, $params);

if ($user == FALSE){
    $_SESSION['error']  = "Aucun utilisateur n'est enregistré sous ce nom, réessayez.";
    header('Location: ../userConnection.phtml');
    return;
}
if ($post['password'] !== $user['password']){
    $_SESSION['error']  =  "Le nom d'utilisateur et le mot de passe fournis ne correspondent pas. Réessayez.";
    header('Location: ../userConnection.phtml');
    return;
}

if ($post['password'] == $user['password']){

    $_SESSION['connectedUser'] = $user;
    $_SESSION['error']  = NULL;
}

header('Location: ../index.phtml');

