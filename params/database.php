<?php

class Database
{
    private $conn;


    public function __construct ()
    {
        $servername = "localhost";
        $username = "root";
        $password = "root";



        try {
            $this->conn = new PDO("mysql:host=$servername;dbname=3WA-projetFin", $username, $password);

//            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // echo "Connected successfully";

        } catch(PDOException $e) {

            echo "Connection failed: " . $e->getMessage();

        }
    }

    public function sendQuery ($sql, $params)
    {

        $query = $this->conn->prepare($sql);
        if($params) {
            $query->bindParam($params['variableName'], $params['variableValue'], $params['PDOparam']);
        }


        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne ($sql, $params)
    {

        $query = $this->conn->prepare($sql);



        $query->execute([$params]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

        public function saveExercise ($exerciseName, $exerciseData) {
            var_dump($exerciseName);
            var_dump($exerciseData);



            try {

                $tableName = 'unorderedSentences';

                $stmt = $this->conn->prepare("INSERT INTO $tableName (`exerciseId`, `sentence`) VALUES (NULL, :exerciseValue)");
                $stmt->execute(['exerciseValue' => $exerciseData]);

            } catch (PDOException $e)
            {
                echo "Error: " . $e->getMessage();
            }


        }


}
