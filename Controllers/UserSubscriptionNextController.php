<?php

class UserSubscriptionNextController extends Controller
{
    public $birthday;

    public function __construct($target)
    {
        $this->setTitle('Inscription');
        $this->setDescription('Page d\'inscription pour un nouvel utilisateur');

        $this->recievePostForm();
        var_dump($this->postResult);
        $this->setBirthday();
        $this->updateDatabase();
        $this->saveToSession();


        $data['languages'] = $this->getLanguages();


        parent::__construct($target, $data);


    }

    public function setBirthday()
    {
        $this->birthday =
            $this->postResult['year'] . "-" .
            substr("0" . $this->postResult['month'], -2) . "-" .
            substr("0" . $this->postResult['day'], -2);

    }

    public function updateDatabase()
    {

        $this->postResult['userId'] = (int)$this->postResult['userId'];

        require_once('./models/UsersModel.php');
        $data = new UsersModel();
        $data->saveNewUserQuerySecondStep();
        $data->saveNewUserParameterSecondStep($this->postResult['firstname'], $this->postResult['lastname'], $this->postResult['country'], $this->birthday, (int)$this->postResult['userId']);
        $data->updateDB();


    }

    public function saveToSession()
    {
        $_SESSION['user']['userFirstname'] = $this->postResult['firstname'];
        $_SESSION['user']['userLastname'] = $this->postResult['lastname'];

    }

    public function getLanguages()
    {

        require('./models/userSubscriptionModel.php');

        $subs = new userSubscriptionModel();

        $languages = $subs->getLanguages();

        return $languages;


    }
}






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
