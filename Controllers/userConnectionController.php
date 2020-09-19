<?php
require('../connect.php');
require('../params/database.php');

$post = $_POST;

$data = new Database();

$sql = "SELECT * FROM `users` WHERE `users`.`username` = ?";
$params = [$post['username']];

$user = $data->getSingleData($sql, $params);

if ($user == FALSE){
    echo "Aucun utilisateur n'est enregistré sous ce nom, réessayez.";
    return;
}
if ($post['password'] !== $user['password']){
    echo "Le nom d'utilisateur et le mot de passe fournis ne correspondent pas. Réessayez.";
    return;
}

if ($post['password'] == $user['password']){
    echo 'Bienvenue ' . ucfirst($user['firstname']);
    $_SESSION['connectedUser'] = $user;
}

header('Location: ../index.phtml');

