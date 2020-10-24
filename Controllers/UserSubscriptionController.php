<?php


class UserSubscriptionController extends Controller
{
    private $userId;

    public function __construct($target)
    {
        $this->setTitle('Inscription');


        $this->recievePostForm();
        $this->saveToDatabase();
        $this->saveToSession();

        $countries = $this->getCountries();


        $data['countries'] = $countries;


        parent::__construct($target, $data);
    }

    public function saveToDatabase()
    {
        require_once('/Applications/MAMP/htdocs/3WA-projetFin/tools/database.php');

        $database = new Database();

        $sql = 'INSERT INTO users (`username`, `email`, `password`, `role`) VALUES (?, ?, ?, "student")';

        $params = [$this->postResult['username'], $this->postResult['email'], $this->postResult['password']];

        $this->userId = $database->saveToDb($sql, $params);


    }

    public function saveToSession()
    {
        $_SESSION['user'] = [
            'userName' => $this->postResult['username'],
            'userId' => $this->userId,
            'userMail' => $this->postResult['email']
        ];
    }

    public function getCountries()
    {
        require('./models/userSubscriptionModel.php');
        $subs = new userSubscriptionModel();
        $countries = $subs->getCountries();

        return $countries;
    }
}

/*
 *
 * 1ere etape
 * username
 * email
 * password
 * INSERT INTO users (`username`, `email`, `password`) VALUES ('test', 'test', 'test')
 */

/*
$database = new Database();
$sql = 'INSERT INTO users (`username`, `email`, `password`, `role`) VALUES (?, ?, ?, "student")';
$params = [$newUser['username'], $newUser['email'], $newUser['password']];

$save = $database->saveToDb($sql, $params);

$_SESSION['user'] = [
    'userName' => $newUser['username'],
    'userId' => $save,
    'userMail' => $newUser['email']
];

header('Location: ../userSubscription.phtml');
                                                         */

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


/*
 *
 * 3e etape
 * langue maternelle
 * langues connues et niveau
 * UPDATE `users` SET `motherlanguage` = 'test', `knowlanguages` = 'test' WHERE `users`.`id` = xx
 *
 */