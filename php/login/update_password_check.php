
<?php

use db\dbConnection;

session_start();
if(empty($_SESSION['visited']))
{
$_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];
header("Location: ../login/logincheck.php"); 
}
else{
unset($_SESSION['visited']);
?>

<?php
require_once '../db/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

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
    $email = $_SESSION["email"];
    $newpassword = md5($_POST["pass"]);
    $oldpassword = md5($_POST["oldpass"]);

     $ds = "SELECT email FROM user where email = '$email' and password = '$oldpassword'; ";
     $result = mysqli_query($connection, $ds);
    if (mysqli_fetch_assoc($result)) {
        $d = "UPDATE user SET password = '$newpassword' WHERE email = '$email' ;";
        $r = mysqli_query($connection, $d);
        if($r){
            header("Location: ../pages/account.php");
        }

     
   }
   else{

     echo "User not found";
    }

mysqli_free_result($result);
mysqli_close($connection);
}
}
else{
    die("Bad Request");
}
?>

<?php  } ?>