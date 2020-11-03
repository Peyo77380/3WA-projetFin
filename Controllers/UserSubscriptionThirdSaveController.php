<?php


/*
 *
 * 3e etape
 * langue maternelle
 * langues connues et niveau
 * UPDATE `users` SET `motherlanguage` = 'test', `knowlanguages` = 'test' WHERE `users`.`id` = xx
 *
 */

class UserSubscriptionThirdSaveController extends Controller
{
    public $knowLanguages;

    public function __construct($target, $data = [])
    {
        $this->setTitle('Inscription');
        $this->setDescription('Page d\'inscription pour un nouvel utilisateur');

        $this->recievePostForm();
        $this->setKnownLanguages();
        $this->updateDatabase();
        parent::__construct($target, $data);
    }

    public function setKnownLanguages()
    {

        $this->knownLanguages = '';

        if ($this->postResult['furtherLanguage1']) {
            $this->knownLanguages = $this->knownLanguages . $this->postResult['furtherLanguage1'];
            if (isset($this->postResult['furtherLanguage1Lvl'])) {
                $this->knownLanguages = $this->knownLanguages . "-" . $this->postResult['furtherLanguage1Lvl'] . "/";
            }
        }

        if ($this->postResult['furtherLanguage2']) {
            $this->knownLanguages = $this->knownLanguages . $this->postResult['furtherLanguage2'];
            if (isset($this->postResult['furtherLanguage2Lvl'])) {
                $this->knownLanguages = $this->knownLanguages . "-" . $this->postResult['furtherLanguage2Lvl'] . "/";
            }
        }

        if ($this->postResult['furtherLanguage3']) {
            $this->knownLanguages = $this->knownLanguages . $this->postResult['furtherLanguage3'];
            if (isset($this->postResult['furtherLanguage3Lvl'])) {
                $this->knownLanguages = $this->knownLanguages . "-" . $this->postResult['furtherLanguage3Lvl'] . "/";
            }
        }


    }



    public function updateDatabase()
    {

        $this->postResult['userId'] = (int)$this->postResult['userId'];

        require_once('./models/UsersModel.php');
        $data = new UsersModel();
        $data->saveNewUserQueryThirdStep();
        $data->saveNewUserParameterThirdStep($this->postResult['motherLanguage'], $this->knownLanguages, (int)$this->postResult['userId']);
        $data->updateDB();


    }
}


