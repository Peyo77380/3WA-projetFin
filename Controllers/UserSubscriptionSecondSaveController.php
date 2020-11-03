<?php

class UserSubscriptionSecondSaveController extends Controller
{
    public $birthday;

    public function __construct($target)
    {
        $this->setTitle('Inscription');
        $this->setDescription('Page d\'inscription pour un nouvel utilisateur');

        $this->recievePostForm();

        $this->checkEmptyField([
            'prénom' => $this->postResult['firstname'],
            'nom' => $this->postResult['lastname'],
            'pays' => $this->postResult['country'],
            'année de naissance' => $this->postResult['year'],
            'mois de naissance' => $this->postResult['month'],
            'jour de naissance' => $this->postResult['day'],
        ], 'userSubscriptionSecond');

        $this->setBirthday();

        $this->updateDatabase();
        $this->saveToSession();
        header('Location: /userSubscriptionThird');
        $data = [];

        parent::__construct($target, $data);


    }

    public function setBirthday()
    {
        $this->birthday = $this->postResult['year'];
        $this->birthday .= "-";
        $this->birthday .= substr("0" . $this->postResult['month'], -2);
        $this->birthday .= "-";
        $this->birthday .= substr("0" . $this->postResult['day'], -2);

    }

    public function updateDatabase()
    {

        $this->postResult['userId'] = (int)$this->postResult['userId'];


        require_once('./models/UsersModel.php');
        $data = new UsersModel();
        $data->saveNewUserParameterSecondStep(
            $this->postResult['firstname'],
            $this->postResult['lastname'],
            $this->postResult['country'],
            $this->birthday,
            $this->postResult['userId']);
        $data->saveNewUserQuerySecondStep();
        $data->updateDB();


    }

    public function saveToSession()
    {
        $_SESSION['user']['userFirstname'] = $this->postResult['firstname'];
        $_SESSION['user']['userLastname'] = $this->postResult['lastname'];

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
