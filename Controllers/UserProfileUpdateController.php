<?php

class UserProfileUpdateController extends Controller
{
    public function __construct()
    {

        $this->recievePostForm();
        var_dump($this->postResult);
        $this->updateUserInDb();

        header('Location: /' . $this->postResult['origin']);

        die();

        parent::__construct($target, $formattedLanguages);


    }

    public function updateUserInDb()
    {
        require_once('./models/UsersModel.php');

        $data = new UsersModel();
        $data->setUpdateQuery($this->postResult['selectedField']);
        $data->setUserId($this->postResult['userId']);
        $data->setUpdatedValue($this->postResult['newValue']);
        $data->launchDBRequest();

    }
}