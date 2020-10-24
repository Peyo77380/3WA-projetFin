<?php

class UserConnectionModuleController extends Controller
{
    public $userData;

    public function __construct($target)
    {
        $this->setTitle('Confirmation de connection');
        $this->setDescription('Confirmation de connection d\un utilisateur connu');
        $this->recievePostForm();
        $this->searchExistingUser();

        parent::__construct($target, $this->userData);

    }

    public function searchExistingUser()
    {
        require('/Applications/MAMP/htdocs/3WA-projetFin/tools/database.php');
        $data = new Database();

        $sql = "SELECT * FROM `users` WHERE `users`.`username` = ?";
        $params = [$this->postResult['username']];

        $user = $data->getSingleData($sql, $params);

        if ($user == FALSE) {
            $_SESSION['error'] = "Aucun utilisateur n'est enregistré sous ce nom, réessayez.";
            header('Location: userConnection');
            return;
        }
        if ($this->postResult['password'] !== $user['password']) {
            $_SESSION['error'] = "Le nom d'utilisateur et le mot de passe fournis ne correspondent pas. Réessayez.";
            header('Location: userConnection');
            return;
        }

        if ($this->postResult['password'] == $user['password']) {
            $this->userData = $user;
            $_SESSION['connectedUser'] = $user;
            $_SESSION['error'] = NULL;
        }

        // header('Location: /index');
    }


}
