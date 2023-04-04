<?php

namespace db;

class dbConnection
{

private $host;
private $database;
private $user;
private $password;
private $connection;


// $host = "localhost";
// $database = "project";
// $user = "webuser";
// $password = "P@ssw0rd";

//$host = "cosc360.ok.ubc.ca";
//$database = "db_11505328";
//$user = "11505328";
//$password = "11505328";

    public function __construct()
    {
        $this->host = "localhost";
        $this->database = "project";
        $this->user = "webuser";
        $this->password = "P@ssw0rd";
        $this->connection = mysqli_connect($this->host, $this->user, $this->password, $this->database);
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function closeConnection()
    {
        mysqli_close($this->connection);
    }

}