<?php

// gère les réponses du formulaire de correction.
class UserConnectionModuleController extends Controller
{
    public $userData;

    public function __construct($target)
    {
        $this->setTitle('Confirmation de connection');
        $this->setDescription('Confirmation de connection d\un utilisateur connu');
        $this->recievePostForm();
        $this->searchExistingUser('userConnection');

        parent::__construct($target, $this->userData);

    }

    public function searchExistingUser($origin)
    {
        //cherche si l'utilisateur existe déjà en DB par son login ou par son mail
        // s'il existe : ses infos sont stockées en session
        // sinon une exception est renvoyée pour une redirection avec message d'erreur
        require_once('./models/UsersModel.php');

        $data = new UsersModel();
        $data->setGetSingleUserQueryByUsername();
        $data->setUsername($this->postResult['username']);
        $user = $data->launchDBSingleRequest();

        if ($user == FALSE) {
            throw new Exception(json_encode(
                [
                    'message' => 'noKnownUser',
                    'origin' => $origin,
                ]));

        }

        if (password_verify($this->postResult['password'], $user['password']) !== true) {
            throw new Exception(json_encode(
                [
                    'message' => 'notMatchingUserCredentials',
                    'origin' => $origin,
                ]));

        }

        $this->userData = $user;
        $_SESSION['connectedUser'] = $user;
        $_SESSION['error'] = NULL;


    }


}
