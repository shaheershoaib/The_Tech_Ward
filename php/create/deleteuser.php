
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
 
 if(empty($_SESSION["email"]) ) {
 header("Location: ../../html/login.html");
}else{


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
    

     $ds = "DELETE FROM user where email = '$email' ; ";
     $result = mysqli_query($connection, $ds);
     header("Location: ../../html/homepage.html");
    
}

mysqli_free_result($result);
mysqli_close($connection);
}
?>
</body>
</html>
<?php  } ?>