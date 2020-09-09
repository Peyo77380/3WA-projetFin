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

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            echo "Connected successfully";

        } catch(PDOException $e) {

            echo "Connection failed: " . $e->getMessage();

        }
    }

    public function sendQuery ($query, $params)
    {
        $statement = $this->conn->prepare($query);
        $statement->execute([$params]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

}
