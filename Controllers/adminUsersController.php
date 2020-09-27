<?php


require('./models/userSubscriptionModel.php');

$data = new Database();

$studentsSql = "SELECT 
                    id,
                    username,
                    firstname,
                    lastname,
                    motherlanguage,
                    knownlanguages,
                    country,
                    birthdate,
                    subscribedate,
                    email
                FROM users
                WHERE role= 'student'
";


$students = $data->sendQuery($studentsSql, '');

$users = [];
foreach ($students as $student)
{

    if ($student['motherlanguage']){
        $defaultAnswer = $student['motherlanguage'];

        $subs = new userSubscriptionModel();

        $languageInfos = $subs->getLanguage($student['motherlanguage']);

        if($languageInfos != []) {
            $student['motherlanguage'] = $languageInfos;
        }
    }



    if($student['knownlanguages']) {

        $student['knownlanguages'] =  explode("/", $student['knownlanguages']);

        $knowlanguage = [];

        foreach ($student['knownlanguages'] as $language)
        {

            if($language == ''){
                break;
            }
            $language = explode("-", $language);

            //va cherche dans liste iso des langues le nom développé de la langue en français

            $subs = new userSubscriptionModel();

            $languageInfos = $subs->getLanguage($language[0]);

            if(!isset($languageInfos['languageName'])) {
                $languageInfos['languageName'] = $language[0];
            }

            if(isset($language[1])){
                $languageInfos['languageLvl'] = $language[1];
            } else {
                $languageInfos['languageLvl'] = 'Non renseigné';

            }




            $knowlanguage[] = $languageInfos;

        }

        $student['knownlanguages']= $knowlanguage;

    }

    $users[] = $student;
}



