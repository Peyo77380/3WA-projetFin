<?php

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
