<?php

class Database
{
    private $pdo;


    public function __construct()
    {

        $dbSettings = parse_ini_file('/Applications/MAMP/htdocs/3WA-projetFin/tools/config/databaseConfig.ini');

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
        $query = $this->pdo->prepare($sql);

        $query->execute($params);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function update ($sql, $params)
    {

        $query = $this->pdo->prepare($sql);
        var_dump($params);
        if ($params) {
            foreach ($params as $param) {
                $query->bindParam($param['variableName'], $param['variableValue'], $param['PDOparam']);

            }
        }


        $query->execute();
        var_dump($query);

    }

    public function saveToDb ($sql, $params)
    {
        $query = $this->pdo->prepare($sql);
        if ($params) {
            foreach ($params as $param) {
                $query->bindParam($param['variableName'], $param['variableValue'], $param['PDOparam']);

            }
        }

        $query->execute();

        $id = $this->pdo->lastInsertId();
        var_dump($query);
        return $id;
    }

}
