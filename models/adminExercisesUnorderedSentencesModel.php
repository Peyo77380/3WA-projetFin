<?php

require('./tools/database.php');

class adminExercisesUnorderedSentencesModel
{
    public $result;
    private $query;
    private $params;

    public function getSentences()
    {
        $data = new Database();

        if (!isset($this->params)){
            $this->params = [];
        }
        $this->result = $data->sendQuery($this->query, $this->params);

        return $this->result;

    }

    public function setQuery()
    {
        $this->query = "SELECT * FROM `unorderedSentences`";

        return $this->query;
    }

    public function setSingleQuery ()
    {
        $this->query = "SELECT * FROM `unorderedSentences` WHERE `exerciseId`= ?";

        return $this->query;
    }

    public function setParams ($id)
    {
        $this->params = $id;

        return $this->params;
    }

}