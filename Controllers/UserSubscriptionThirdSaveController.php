<?php

// gère la réception du formulaire d'inscrption 3/3
class UserSubscriptionThirdSaveController extends Controller
{
    public $knownLanguages;

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
        // formatte la réponse du formulaire concernant les langues connues et le niveau de chacune des langues
        // renvoie une string contenant chacune des valeurs
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


