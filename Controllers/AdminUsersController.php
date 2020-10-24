<?php

class AdminUsersController extends Controller
{
    public $usersArray;
    public $result;

    public function __construct($target, $data = [])
    {
        $this->setTitle('Gestion des utilisateurs');
        $this->setDescription('Page de gestion des utilisateurs enregistrés.');

        require_once('./models/UsersModel.php');
        $userDb = new UsersModel();
        $userDb->setQuery();
        $userDb->setUserCategory('teacher');
        $this->usersArray = $userDb->getUsers();
        // $this->getUsers('teacher');

        $this->getLanguagesInfo();


        parent::__construct($target, $this->result);
    }

    public function getLanguagesInfo()
    {
        //va cherche dans liste iso des langues le nom développé de la langue en français
        $users = [];
        foreach ($this->usersArray as $student) {

            if ($student['motherlanguage']) {
                require_once('./models/userSubscriptionModel.php');
                $defaultAnswer = $student['motherlanguage'];

                $subs = new userSubscriptionModel();

                $languageInfos = $subs->getLanguage($student['motherlanguage']);

                if ($languageInfos != []) {
                    $student['motherlanguage'] = $languageInfos;
                }
            }


            if ($student['knownlanguages']) {

                $student['knownlanguages'] = explode("/", $student['knownlanguages']);

                $knowlanguage = [];

                foreach ($student['knownlanguages'] as $language) {

                    if ($language == '') {
                        break;
                    }
                    $language = explode("-", $language);


                    $subs = new userSubscriptionModel();

                    $languageInfos = $subs->getLanguage($language[0]);

                    if (!isset($languageInfos['languageName'])) {
                        $languageInfos['languageName'] = $language[0];
                    }

                    if (isset($language[1])) {
                        $languageInfos['languageLvl'] = $language[1];
                    } else {
                        $languageInfos['languageLvl'] = 'Non renseigné';

                    }


                    $knowlanguage[] = $languageInfos;

                }

                $student['knownlanguages'] = $knowlanguage;

            }

            $users[] = $student;
        }


        $this->result['students'] = $users;
    }


}
