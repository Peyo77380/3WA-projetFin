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

    public function saveToDatabase()
    {
        require_once('./models/UsersModel.php');

        $data = new UsersModel();
        $data->saveNewUserQuery();
        $data->saveNewUserParameter($this->postResult['username'], $this->postResult['email'], $this->postResult['password']);
        $this->userId = $data->saveToDB();

    }

    public function saveToSession()
    {
        $_SESSION['user'] = [
            'userName' => $this->postResult['username'],
            'userId' => $this->userId,
            'userMail' => $this->postResult['email']
        ];
    }

    public function hashPassword()
    {
        // sel aleatoire : string aleatoire : le début du salt est une clé indiquant l'algo utilisé dans le hash. Ici bcrypt.
        $salt = '$2y$11$' . substr(bin2hex(openssl_random_pseudo_bytes(32)), 0, 22);

        // hash avec bcrypt
        // bcrypt stocke le sel dans le hash donc pas besoin de champ supplementaires
        $this->postResult['password'] = crypt($this->postResult['password'], $salt);

    }

    public function searchExistingUser()
    {
        require_once('./models/UsersModel.php');

        $login = new UsersModel();
        $login->setGetSingleUserQueryByUsername();
        $login->setUsername($this->postResult['username']);
        $checkLogin = $login->launchDBSingleRequest();
        if ($checkLogin != FALSE) {
            throw new Exception('Le login est déjà pris');


        }

        $email = new UsersModel();
        $email->setGetSingleUserQueryByEmail();
        $email->setEmail($this->postResult['email']);
        $checkEmail = $email->launchDBSingleRequest();

        if ($checkEmail != FALSE) {
            throw new Exception('Cet email est déjà lié à un compte.');


        }

    }


}
