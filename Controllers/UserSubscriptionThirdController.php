<?php

// gère le 3e formulaire d'inscription.
class UserSubscriptionThirdController extends Controller
{


    public function __construct($target)
    {
        $this->setTitle('Inscription');
        $this->setDescription('Page d\'inscription pour un nouvel utilisateur');

        $data['languages'] = $this->getLanguages();


        parent::__construct($target, $data);


    }

    public function getLanguages()
    {
        // récupère les langues
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
