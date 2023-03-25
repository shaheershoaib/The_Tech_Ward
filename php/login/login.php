<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if(empty($_POST["email"]) || empty($_POST["password"])) {
        die("Input fields are missing");
      }else{


$host = "localhost";
$database = "project";
$user = "webuser";
$password = "P@ssw0rd";

// $host = "cosc360.ok.ubc.ca";
// $database = "db_11505328";
// $user = "11505328";
// $password = "11505328";
$connection = mysqli_connect($host, $user, $password, $database);
$error = mysqli_connect_error();
if($error != null)
{
  $output = "<p>Unable to connect to database!</p>";
  exit($output);
}
else
{
    $email = $_POST["email"];
    $password = md5($_POST["password"]);

     $ds = "SELECT email FROM user WHERE email = '$email' and password ='$password';";
     $result = mysqli_query($connection, $ds);
    if (mysqli_fetch_assoc($result)) {
      session_start();
      $_SESSION["email"] = $email;
        header("Location: logincheck.php");
        exit();
      
   }else{
    echo "Sorry, Invalid credentials or user not found";
   }
   
}
mysqli_free_result($r);
mysqli_free_result($result);
mysqli_close($connection);
}
}
else{
    die("Bad Request");
}
?>