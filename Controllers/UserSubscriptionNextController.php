<?php

class UserSubscriptionNextController extends Controller
{
    public $birthday;

    public function __construct($target)
    {
        $this->recievePostForm();
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
        require_once('/Applications/MAMP/htdocs/3WA-projetFin/tools/database.php');
        $database = new Database();
        $sql = "UPDATE `users` SET `firstname` = ?, `lastname` = ?, `country` = ?, `birthdate` = STR_TO_DATE(?,'%Y-%m-%d')  WHERE `users`.`id` = ?";
        $params = [
            // firstname
            $this->postResult['firstname'],
            //lastname
            $this->postResult['lastname'],
            //country
            $this->postResult['country'],
            //birthdate
            $this->birthday,
            //userId
            $this->postResult['userId']
        ];

        $save = $database->update($sql, $params);
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
