<?php

require ('./params/database.php');

class adminExercisesUnorderedSentencesModel
{
    public $result;
    private $query;

    public function getSentences()
    {
        $data = new Database();

        $this->result = $data->sendQuery($this->query, []);

        return $this->result;

    }

    public function setQuery()
    {
        $this->query = "SELECT * FROM `unorderedSentences`";

        return $this->query;
    }

}