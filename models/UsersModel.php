<?php

require('./tools/database.php');

class UsersModel
{
    public $result;
    public $data;
    public $query;
    public $params = [];

    public function launchDBRequest()
    {


        $this->data = new Database();

        $this->result = $this->data->sendQuery($this->query, $this->params);

        return $this->result;
    }


    public function launchDBSingleRequest()
    {


        $this->data = new Database();

        $this->result = $this->data->getSingleData($this->query, $this->params);

        return $this->result;
    }

    public function saveToDB()
    {
        $this->data = new Database();

        $this->result = $this->data->saveToDb($this->query, $this->params);

        return $this->result;

    }

    public function updateDB()
    {
        $this->data = new Database();

        $this->result = $this->data->update($this->query, $this->params);

    }

    public function setGetterQuery()
    {
        $this->query = "SELECT * FROM `users` WHERE `role`= :userCategory";

    }

    public function setGetSingleUserQueryById()
    {
        $this->query = "SELECT * FROM `users` WHERE `users`.`id` = :userId";
    }

    public function setGetSingleUserQueryByUsername()
    {
        $this->query = "SELECT * FROM `users` WHERE `users`.`username` = :username";
    }

    public function saveNewUserQuery()
    {
        $this->query = 'INSERT INTO users (`username`, `email`, `password`, `role`) VALUES (:username, :email, :password, "student")';
    }

    public function saveNewUserQuerySecondStep()
    {
        $this->query = "UPDATE `users` SET `users`.`firstname` = :firstname, `users`.`lastname` = :lastname, `users`.`birthdate` = :birthdate, `users`.`country` = :country WHERE `users`.`id` = :userid";
    }

    public function saveNewUserQueryThirdStep()
    {
        $this->query = "UPDATE `users` SET `users`.`motherlanguage` = :motherlanguage, `users`.`knownlanguages` = :knownlanguages WHERE `users`.`id` = :userid";
    }

    public function saveNewUserParameter($username, $email, $password)
    {
        $this->params[] = ['variableName' => ':username', 'variableValue' => $username, 'PDOparam' => PDO::PARAM_STR];
        $this->params[] = ['variableName' => ':email', 'variableValue' => $email, 'PDOparam' => PDO::PARAM_STR];
        $this->params[] = ['variableName' => ':password', 'variableValue' => $password, 'PDOparam' => PDO::PARAM_STR];
    }

    public function saveNewUserParameterSecondStep(string $firstname, string $lastname, string $country, string $birthdate, int $userid)
    {
        $this->params[] = ['variableName' => ':firstname', 'variableValue' => $firstname, 'PDOparam' => PDO::PARAM_STR];
        $this->params[] = ['variableName' => ':lastname', 'variableValue' => $lastname, 'PDOparam' => PDO::PARAM_STR];
        $this->params[] = ['variableName' => ':country', 'variableValue' => $country, 'PDOparam' => PDO::PARAM_STR];
        $this->params[] = ['variableName' => ':birthdate', 'variableValue' => $birthdate, 'PDOparam' => PDO::PARAM_STR];
        $this->params[] = ['variableName' => ':userid', 'variableValue' => $userid, 'PDOparam' => PDO::PARAM_INT];
    }

    public function saveNewUserParameterThirdStep(string $motherlanguage, string $knownlanguages, int $userId)
    {
        $this->params[] = ['variableName' => ':motherlanguage', 'variableValue' => $motherlanguage, 'PDOparam' => PDO::PARAM_STR];
        $this->params[] = ['variableName' => ':knownlanguages', 'variableValue' => $knownlanguages, 'PDOparam' => PDO::PARAM_STR];
        $this->params[] = ['variableName' => ':userid', 'variableValue' => $userId, 'PDOparam' => PDO::PARAM_INT];
    }

    public function setUserCategory(string $userCategory)
    {
        $this->params[] = ['variableName' => ':userCategory', 'variableValue' => $userCategory, 'PDOparam' => PDO::PARAM_STR];


    }

    public function setUpdateQuery(string $updatedField)
    {
        $this->query = "UPDATE `users` SET `users`.`" . $updatedField . "` = :newValue WHERE `users`.`id` = :userId";
    }

    public function setUserId(int $userId)
    {
        $this->params[] = ['variableName' => ':userId', 'variableValue' => $userId, 'PDOparam' => PDO::PARAM_INT];

    }

    public function setUsername(string $username)
    {
        $this->params[] = ['variableName' => ':username', 'variableValue' => $username, 'PDOparam' => PDO::PARAM_STR];

    }

    public function setUpdatedValue(string $newValue)
    {
        $this->params[] = ['variableName' => ':newValue', 'variableValue' => $newValue, 'PDOparam' => PDO::PARAM_STR];

    }

}