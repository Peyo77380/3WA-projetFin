<?php
require('./tools/database.php');

class ExercisesModel
{
    public $result;
    private $data;
    private $query;
    private $params = [];
    private $tableName;

    public function getSentences()
    {

        $this->data = new Database();

        $this->result = $this->data->sendQuery($this->query, $this->params);

        return $this->result;

    }

    public function setQuery()
    {
        $this->query = "SELECT * FROM " . $this->tableName;

        if ($this->params == []) {
            return;

        }

        foreach ($this->params as $definedParameter) {
            if ($definedParameter['variableName'] == ':exerciseId') {
                $this->query .= " WHERE `exerciseId` = :exerciseId";
            }

            if ($definedParameter['variableName'] == ':nbOfSentences') {
                $this->query .= " ORDER BY RAND() LIMIT :nbOfSentences";
            }

        }

    }

    public function setId(int $exerciseId)
    {
        $this->params[] = ['variableName' => ':exerciseId', 'variableValue' => $exerciseId, 'PDOparam' => PDO::PARAM_INT];

        return $this->params;
    }

    public function setNumberOfSentences(int $nbOfSentences)
    {
        $this->params[] = ['variableName' => ':nbOfSentences', 'variableValue' => $nbOfSentences, 'PDOparam' => PDO::PARAM_INT];

        return $this->params;
    }

    public function setTableName($table)
    {
        $this->tableName = $table;

    }

}