<?php

require('./tools/database.php');

class UsersModel
{
    public $result;
    public $data;
    public $query;
    public $params = [];

    public function getUsers()
    {


        $this->data = new Database();

        $this->result = $this->data->sendQuery($this->query, $this->params);

        return $this->result;
    }

    public function setQuery()
    {
        $this->query = "SELECT * FROM `users` WHERE `role`= :userCategory";

    }

    public function setUserCategory($userCategory)
    {
        $this->params[] = ['variableName' => ':userCategory', 'variableValue' => $userCategory, 'PDOparam' => PDO::PARAM_INT];


    }

}