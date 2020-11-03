<?php


class UserSubscriptionSecondController extends Controller
{
    private $userId;

    public function __construct($target)
    {
        $this->setTitle('Inscription');
        $this->setDescription('Page d\'inscription pour un nouvel utilisateur');

        $countries = $this->getCountries();

        $data['countries'] = $countries;


        parent::__construct($target, $data);
    }

    public function getCountries()
    {
        require('./models/userSubscriptionModel.php');
        $subs = new userSubscriptionModel();
        return $subs->getCountries();

    }




}
