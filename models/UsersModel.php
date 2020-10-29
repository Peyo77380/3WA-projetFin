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

    public function setGetterQuery()
    {
        $this->query = "SELECT * FROM `users` WHERE `role`= :userCategory";

    }

    public function setGetSingleUserQuery()
    {
        $this->query = "SELECT * FROM `users` WHERE `users`.`id` = :userId";
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

    public function setUpdatedValue(string $newValue)
    {
        $this->params[] = ['variableName' => ':newValue', 'variableValue' => $newValue, 'PDOparam' => PDO::PARAM_STR];

    }

}