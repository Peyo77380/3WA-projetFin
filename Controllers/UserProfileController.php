<?php

// gere la page de profil de l'utilisateur
class UserProfileController extends Controller
{
    public $result;

    public function __construct($target, $data = [])
    {

        require_once('./models/UsersModel.php');
        require_once('./models/userSubscriptionModel.php');
        $this->setConnectedUserFilter('userConnection');
        $this->setTitle('Votre profil');

        $this->setDescription('Votre profil - Lasciatemi Parlare');
        $this->setScript('userProfile');

        $this->getUserInfo();
        $this->formatLanguages();
        $this->formatCountry();
        $this->result['countries'] = $this->getCountriesList();
        $this->result['languages'] = $this->getLanguagesList();


        parent::__construct($target, $this->result);
    }

    public function getUserInfo()
    {

        // va chercher les infos sur l'utilisateur en DB en fonction de son id stocké en session au moment de la connection.
        $data = new UsersModel();
        $data->setGetSingleUserQueryById();
        $data->setUserId($_SESSION['connectedUser']['id']);
        $this->result = $data->launchDBRequest();

    }

    public function formatCountry()
    {
        // met en forme les pays en fonction du code iso renvoyé
        $helper = new userSubscriptionModel();
        $this->result[0]['country'] = $helper->getCountry($this->result[0]['country']);

    }

    public function formatLanguages()
    {
        // met en forme les langues en fonction du code iso renvoyé
        $helper = new userSubscriptionModel();

        $this->result[0]['motherlanguage'] = $helper->getLanguage($this->result[0]['motherlanguage']);

    }

    public function getCountriesList()
    {
        // renvoie les listes de pays pour les <select> en cas de modification
        $subs = new userSubscriptionModel();
        $countries = $subs->getCountries();

        return $countries;
    }

    public function getLanguagesList()
    {
        // renvoie les listes de langues pour les <select> en cas de modification
        $subs = new userSubscriptionModel();
        $languages = $subs->getLanguages();

        return $languages;
    }
}