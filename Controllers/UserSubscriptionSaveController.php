<?php


class UserSubscriptionSaveController extends Controller
{
    private $userId;

    public function __construct($target)
    {

        $this->setTitle('Inscription');
        $this->setDescription('Page d\'inscription pour un nouvel utilisateur');

        $_SESSION['error'] = [];
        $this->recievePostForm();
        var_dump($this->postResult);


        $this->checkEmptyField([
            'login' => $this->postResult['username'],
            'email' => $this->postResult['email'],
            'mot de passe' => $this->postResult['password']
        ], 'userConnection');
        $this->checkPassword($this->postResult['password'], 'userConnection');


        $this->checkEmail($this->postResult['email'], 'userConnection');
        $this->searchExistingUser();

        $this->hashPassword();
        $this->saveToDatabase();
        $this->saveToSession();

        header('Location: /userSubscriptionSecond');
        return;


        parent::__construct($target, $data);


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

    public function getCountries()
    {
        require('./models/userSubscriptionModel.php');
        $subs = new userSubscriptionModel();
        return $subs->getCountries();

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


    public function checkEmail(string $email, $origin)
    {

        if (!preg_match("/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/", $email)) {
            throw new Exception (
                json_encode([
                        'message' => 'email',
                        'origin' => $origin
                    ]
                )
            );
        }
    }

    public function checkPassword($password, $origin)
    {


        if (!preg_match("/^(?=(?:.*[A-Z]))(?=(?:.*[a-z]))(?=(?:.*\d))(?=(?:.*[!@#$%^&*()\-_=+{};:,<.>]))(.{8,})$/", $password)) {
            throw new Exception (
                json_encode([
                        'message' => 'password',
                        'origin' => $origin
                    ]
                )
            );

        }


    }


}
