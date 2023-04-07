<?php

use db\dbConnection;

require_once '../db/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if(empty($_POST["email"]) || empty($_POST["password"])) {
        die("Input fields are missing");
      }else{

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
    $email = $_POST["email"];
    $password = md5($_POST["password"]);

     $ds = "SELECT email, admin, disabled FROM user WHERE email = '$email' and password ='$password';";
     $result = mysqli_query($connection, $ds);
    if ($row = mysqli_fetch_assoc($result)) {


        session_start();
        session_destroy(); // Destroy any session data previously just in case
        session_start(); //Start a new session

        if($row["disabled"] == 1)
        {
            echo $row["disabled"];
            header("Location: ../pages/disabledMessage.php");
            exit();
        }

      $_SESSION["email"] = $email;

      if($row['admin'] == true)
      {
        $_SESSION['admin'] = 1;
        header("Location: ../pages/admin/admin.php");


      }
      else header("Location: logincheck.php");

      
   }else{
    echo "Sorry, Invalid credentials or user not found";
   }
   
}
mysqli_free_result($result);
mysqli_close($connection);
}
}
else{
    die("Bad Request");
}
?>