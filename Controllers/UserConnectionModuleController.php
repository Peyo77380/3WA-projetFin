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
        require_once('./models/UsersModel.php');

        $data = new UsersModel();
        $data->setGetSingleUserQueryByUsername();
        $data->setUsername($this->postResult['username']);
        $user = $data->launchDBSingleRequest();

        if ($user == FALSE) {
            $_SESSION['error'] = "Aucun utilisateur n'est enregistré sous ce nom, réessayez.";
            header('Location: userConnection');
            return;
        }

        if (password_verify($this->postResult['password'], $user['password']) !== true) {
            $_SESSION['error'] = "Le nom d'utilisateur et le mot de passe fournis ne correspondent pas. Réessayez.";
            header('Location: userConnection');

            return;
        }

        $this->userData = $user;
        $_SESSION['connectedUser'] = $user;
        $_SESSION['error'] = NULL;


    }


}
