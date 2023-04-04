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

     $ds = "SELECT email, admin FROM user WHERE email = '$email' and password ='$password';";
     $result = mysqli_query($connection, $ds);
    if ($row = mysqli_fetch_assoc($result)) {
      session_start();
      $_SESSION["email"] = $email;
      if($row['admin'] == true){
        $_SESSION['admin'] = true;
        header("Location: ../pages/admin.php");
        exit();
      }else{
        header("Location: logincheck.php");
        exit();
      }
      
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