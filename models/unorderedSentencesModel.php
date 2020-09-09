<?php
require('./params/database.php');

class UnorderedSentencesModel
{
    public $result;
    private $query;
    private $params;

    public function getSentences () {
        //replace by a sql query to database
        $pdo = new database();

        $this->result = $pdo->sendQuery($this->query, $this->params);

        return $this->result;

    }

    public function setQuery () {
        $this->query = "SELECT * FROM `unorderedSentences` ORDER BY RAND() LIMIT ?";
    }

    public function setParams (int $nbOfSentences){
        $this->params = $nbOfSentences;
        
    }


}