<?php


use db\dbConnection;

require_once 'db/dbConnection.php';
$dbConnection = new dbConnection();
$connection = $dbConnection->getConnection();
$error = $dbConnection->getError();
if($error != null)
{
  $output = "<p>Unable to connect to database!</p>";
  exit($output);
}
else
{
   
    $fullname = "Admin";
    $email = "admin@admin.com";
    $admin = true;
    $password = md5("Admin@12345");

                   
            try
            {
            $sql = "INSERT INTO user(fullname, email, password, admin) VALUES('$fullname', '$email', '$password', '$admin');";
            $result = mysqli_query($connection, $sql);
            }
            catch(Exception $e)
            {
                echo 'Error: ' . $e->getMessage();
                exit();
            }

        header("Location: ../html/login.html");


    mysqli_close($connection);
    exit();


    }







    
?>