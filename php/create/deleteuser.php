
<?php 

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
 
 if(empty($_SESSION["email"]) ) {
 header("Location: ../../html/login.html");
}else{
// $host = "localhost";
// $database = "project";
// $user = "webuser";
// $password = "P@ssw0rd";

$host = "cosc360.ok.ubc.ca";
$database = "db_11505328";
$user = "11505328";
$password = "11505328";


$connection = mysqli_connect($host, $user, $password, $database);
$error = mysqli_connect_error();
if($error != null)
{
  $output = "<p>Unable to connect to database!</p>";
  exit($output);
}
else
{
    $email = $_SESSION["email"];
    

     $ds = "DELETE FROM user where email = '$email' ; ";
     $result = mysqli_query($connection, $ds);
     header("Location: ../../html/signup.html");
    
}

mysqli_free_result($result);
mysqli_close($connection);
}
?>
</body>
</html>
<?php  } ?>