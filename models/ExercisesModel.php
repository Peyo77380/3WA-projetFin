<?php

//gère les actions en DB concernant les exercices.
require_once('./tools/database.php');

class ExercisesModel
{
    public $result;
    private $data;
    private $query;
    private $params = [];
    private $tableName;


    //lance la requete prévue par les différentes fonctions
    public function launchDBRequest()
    {

        $this->data = new Database();

        return $this->result = $this->data->sendQuery($this->query, $this->params);

    }


    /**********************************/
    /**********************************/
    /* différentes requetes possibles */
    /**********************************/
    /**********************************/


    public function setGetterQuery()
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

    public function setSaveQuery()
    {
        $this->query = "INSERT INTO $this->tableName (`exerciseId`, `sentence`) VALUES (NULL, :newExercise)";
    }

    public function setDeleteQuery()
    {
        $this->query = "DELETE FROM $this->tableName WHERE $this->tableName.`exerciseId` = :exerciseId";
    }

    public function setUpdateExerciseQuery()
    {
        $this->query = "UPDATE " . $this->tableName . " SET `sentence` = :newExercise WHERE " . $this->tableName . ".`exerciseId` = :exerciseId ";
    }



    /**********************************/
    /**********************************/
    /* différentes parametres possibles */
    /**********************************/
    /**********************************/

    public function setTableName(string $table)
    {
        $this->tableName = $table;

    }

    public function setId(int $exerciseId)
    {
        $this->params[] = ['variableName' => ':exerciseId', 'variableValue' => $exerciseId, 'PDOparam' => PDO::PARAM_INT];

    }

    public function setNumberOfSentences(int $nbOfSentences)
    {
        $this->params[] = ['variableName' => ':nbOfSentences', 'variableValue' => $nbOfSentences, 'PDOparam' => PDO::PARAM_INT];

    }

    public function setNewExercise(string $newExercise)
    {
        $this->params[] = ['variableName' => ':newExercise', 'variableValue' => $newExercise, 'PDOparam' => PDO::PARAM_STR];

    }


}