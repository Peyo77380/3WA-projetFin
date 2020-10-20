<?php
require('./tools/database.php');

class Exercise
{
    public $result;
    private $query;
    private $params;

    public function getSentences()
    {

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