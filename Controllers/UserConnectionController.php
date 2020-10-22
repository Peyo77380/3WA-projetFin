<?php

//require('/Applications/MAMP/htdocs/3WA-projetFin/tools/database.php');
//require('/Applications/MAMP/htdocs/3WA-projetFin/tools/utilities.php');


class UserConnectionController extends Controller
{
    public function __construct($target)
    {
        parent::__construct($target);
    }
}

/*
$post = $_POST;
$connection = postCleaner($post);

$data = new Database();

$sql = "SELECT * FROM `users` WHERE `users`.`username` = ?";
$params = [$connection['username']];

$user = $data->getSingleData($sql, $params);

if ($user == FALSE) {
    $_SESSION['error'] = "Aucun utilisateur n'est enregistré sous ce nom, réessayez.";
    header('Location: ../userConnection.phtml');
    return;
}
if ($connection['password'] !== $user['password']) {
    $_SESSION['error'] = "Le nom d'utilisateur et le mot de passe fournis ne correspondent pas. Réessayez.";
    header('Location: ../userConnection.phtml');
    return;
}

if ($connection['password'] == $user['password']) {

    $_SESSION['connectedUser'] = $user;
    $_SESSION['error'] = NULL;
}

header('Location: ../index.phtml');

*/