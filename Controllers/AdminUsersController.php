<?php

class AdminUsersController extends Controller
{
    public $usersArray;
    public $result;

    public function __construct($target, $data = [])
    {
        $this->setAdminFilter();
        $this->setAdminFilter();
        $this->setTitle('Gestion des utilisateurs');
        $this->setDescription('Page de gestion des utilisateurs enregistrés.');

        require_once('./models/UsersModel.php');
        $userDb = new UsersModel();
        $userDb->setGetterQuery();
        $userDb->setUserCategory('student');
        $this->usersArray['student'] = $userDb->launchDBRequest();

        $userDb->setUserCategory('teacher');
        $this->usersArray['teacher'] = $userDb->launchDBRequest();

        $this->result['students'] = $this->getLanguagesInfo($this->usersArray['student']);
        $this->result['teachers'] = $this->getLanguagesInfo($this->usersArray['teacher']);

        parent::__construct($target, $this->result);
    }

    public function getLanguagesInfo($array)
    {
        //va cherche dans liste iso des langues le nom développé de la langue en français
        $users = [];
        foreach ($array as $user) {

            if ($user['motherlanguage']) {
                require_once('./models/userSubscriptionModel.php');
                $defaultAnswer = $user['motherlanguage'];

                $subs = new userSubscriptionModel();

                $languageInfos = $subs->getLanguage($user['motherlanguage']);

                if ($languageInfos != []) {
                    $user['motherlanguage'] = $languageInfos;
                }
            }

            $users[] = $user;
        }


        return $users;
    }


}
