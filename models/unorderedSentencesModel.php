<?php
require('./params/database.php');

class UnorderedSentencesModel
{
    public $result;
    private $query;
    private $params;

    public function getSentences()
    {
        //replace by a sql query to database
        $data = new Database();

        $this->result = $data->sendQuery($this->query, $this->params);

        return $this->result;

    }

    public function setQuery($exerciseType)
    {
        $this->query = "SELECT * FROM `" . $exerciseType . "` ORDER BY RAND() LIMIT :nbOfSentences";

        return $this->query;
    }

    public function setParams($nbOfSentences)
    {
        $this->params = ['variableName' => ':nbOfSentences', 'variableValue' => $nbOfSentences, 'PDOparam' => PDO::PARAM_INT];

        return $this->params;
    }


}