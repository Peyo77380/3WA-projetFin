<?php


class UserProfileController extends Controller
{
    public $result;

    public function __construct($target, $data = [])
    {

        require_once('./models/UsersModel.php');
        require_once('./models/userSubscriptionModel.php');
        $this->setConnectedUserFilter();
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


        $data = new UsersModel();
        $data->setGetSingleUserQuery();
        $data->setUserId($_SESSION['connectedUser']['id']);
        $this->result = $data->launchDBRequest();

    }

    public function formatCountry()
    {
        $helper = new userSubscriptionModel();
        $this->result[0]['country'] = $helper->getCountry($this->result[0]['country']);

    }

    public function formatLanguages()
    {

        $helper = new userSubscriptionModel();

        $this->result[0]['motherlanguage'] = $helper->getLanguage($this->result[0]['motherlanguage']);

    }

    public function getCountriesList()
    {

        $subs = new userSubscriptionModel();
        $countries = $subs->getCountries();

        return $countries;
    }

    public function getLanguagesList()
    {
        $subs = new userSubscriptionModel();
        $languages = $subs->getLanguages();

        return $languages;
    }
}