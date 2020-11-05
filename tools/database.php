<?php

class Database
{
    private $pdo;


    public function __construct()
    {

        $dbSettings = parse_ini_file('./tools/config/databaseConfig.ini');

        $dsn = sprintf('mysql:dbname=%s;host=%s', $dbSettings['dbname'], $dbSettings['host']);

        $pdoOptions = [
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->pdo = new PDO(
                $dsn,
                $dbSettings['username'],
                $dbSettings['password'],
                $pdoOptions,
            );

        } catch(PDOException $e) {

            echo "Connection failed: " . $e->getMessage();

        }
    }

    public function sendQuery($sql, array $params = [])
    {
        // envoie une requete avec un fetch all, et en tenant compte des différents paramètres mis en place
        $query = $this->pdo->prepare($sql);
        if ($params) {
            foreach ($params as $param) {
                $query->bindParam($param['variableName'], $param['variableValue'], $param['PDOparam']);

            }
        }


        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSingleData ($sql, $params)
    {
        // envoie une requete avec un fetch , et en tenant compte des différents paramètres mis en place
        $query = $this->pdo->prepare($sql);
        if ($params) {
            foreach ($params as $param) {
                $query->bindParam($param['variableName'], $param['variableValue'], $param['PDOparam']);

            }
        }
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function update ($sql, $params)
    {
        // envoie une requete d'update, et en tenant compte des différents paramètres mis en place
        try {


            $query = $this->pdo->prepare($sql);

            if ($params) {
                foreach ($params as $param) {
                    $query->bindParam($param['variableName'], $param['variableValue'], $param['PDOparam']);

                }
            }


            $query->execute();
        } catch (PDOException $e) {
            throw new Exception ($e);
        }


    }

    public function saveToDb ($sql, $params)
    {
        // envoie une requete d'insertion, et en tenant compte des
        // différents paramètres mis en place et retourne l'index de celle ci
        $query = $this->pdo->prepare($sql);
        if ($params) {
            foreach ($params as $param) {
                $query->bindParam($param['variableName'], $param['variableValue'], $param['PDOparam']);

            }
        }

        $query->execute();

        $id = $this->pdo->lastInsertId();

        return $id;
    }

}
