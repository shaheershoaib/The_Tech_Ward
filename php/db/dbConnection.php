<?php

namespace db;

class dbConnection
{

private $host;
private $database;
private $user;
private $password;
private $connection;
private $error;



    public function __construct()
    {
         $this->host = "localhost";
         $this->database = "project";
         $this->user = "webuser";
         $this->password = "P@ssw0rd";

       // $this->host = "cosc360.ok.ubc.ca";
       // $this->database = "db_11505328";
       // $this->user = "11505328";
       // $this->password = "11505328";

        $this->connection = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        $this->error = mysqli_connect_error();
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function closeConnection()
    {
        mysqli_close($this->connection);
    }

    public function getError()
    {
        return $this->error;
    }

}