
<?php

use db\dbConnection;

session_start();
if(empty($_SESSION['visited']))
{
    if($_SERVER["REQUEST_METHOD"]!= "POST")
    {
        echo "<p>Bad Request</p>";
        exit();
    }

    $_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];
    $_SESSION["oldpass"] = $_POST["oldpass"];
    $_SESSION["pass"] = $_POST["pass"];

header("Location: ../login/logincheck.php");
}
else{
unset($_SESSION['visited']);
$oldpass = $_SESSION["oldpass"];
$pass = $_SESSION["pass"];

unset($_SESSION["oldpass"]);
unset($_SESSION["pass"]);
?>

<?php
require_once '../db/dbConnection.php';



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
    $newpassword = md5($pass);
    $oldpassword = md5($oldpass);

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
    echo $email;
    echo empty($_POST["oldpass"]);
     echo "User not found";
    }

mysqli_free_result($result);
mysqli_close($connection);
}


?>

<?php } ?>