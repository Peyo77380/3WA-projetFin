<?php

class UserProfileUpdateController extends Controller
{
    public function __construct()
    {
        $this->setConnectedUserFilter('userConnection');
        
        $this->recievePostForm();

        if ($this->postResult['selectedField'] === 'email'){
            $this->checkEmail($this->postResult['newValue'], 'userProfile');
        }
        
         if ($this->postResult['selectedField'] === 'username'){
            $this->checkLogin($this->postResult['newValue'], 'userProfile');
        }
        
        $this->updateUserInDb();

        header('Location: /3WA-projetFin/' . $this->postResult['origin']);

        die();

        parent::__construct($target, $formattedLanguages);


    }

    public function updateUserInDb()
    {
        // modifie les infos de l'utilisateur en db
        require_once('./models/UsersModel.php');

        $data = new UsersModel();
        $data->setUpdateQuery($this->postResult['selectedField']);
        $data->setUserId($this->postResult['userId']);
        $data->setUpdatedValue(filter_var(html_entity_decode(htmlspecialchars_decode($this->postResult['newValue'])), FILTER_SANITIZE_STRING));
        $data->launchDBRequest();

    }
    
    public function checkLogin(string $string, $origin)
    {
        
        if (!preg_match('/^\pL+$/u', $string)) {
            throw new Exception (
                json_encode([
                        'message' => 'login',
                        'origin' => $origin
                    ]
                )
            );
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
}