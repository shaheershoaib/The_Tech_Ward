
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




<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="../../css/project.css">
    <link rel="stylesheet" href="../../css/nav.css">
</head>
<body>
<nav>

        <div class="logo"> <a href = "show_discussions.php"><img src="../../images/logo.png" width="100" height="100"></a> </div>
        <div class="n"><div class="text"> <a href = "show_discussions.php"><p> The Tech Ward</p></a></div>
            <ul>
              <li><a href="new_discussion.php">New Discussion</a></li>
                <li><a href="#">Search For Discussion</a></li>
                <li><a href= "account.php">Account</a></li>
                <li><a href="admin.php">Admin</a></li>
                <li><a href="../login/logout.php">Logout</a></li> 
              </ul>
            </nav>

           
            <footer>
            <a href="#">Home</a> | <a href="#">Browse</a> | <a href="#">Search</a><br><br>
            <small><i>Copyright &copy; 2023 The Tech Ward</i></small>
        </footer>







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
    

     $ds = "SELECT fullname, email  FROM user where email = '$email' ; ";
     $result = mysqli_query($connection, $ds);

    if ($row = mysqli_fetch_assoc($result)) {
       
      echo "<br><br><br><br><br><br>

      <h1 align = 'center'> Welcome ".$row["fullname"]." </h1> <br>
      <h2 align = 'center'> Email: " .$row["email"]. "</h2> <br>".
      "<a href='../create/deleteuser.php'>Delete Account </a> <br><br>".
      "<a href='updatepassword.php'>Update Password</a> <br><br>".
      "<a href = 'my_discussions.php'>My Discussions</a>";
        
   }
   else{

      echo "Uhh, User not found!!";
    }
}
mysqli_free_result($row);
mysqli_free_result($result);
mysqli_close($connection);
}


?>



</body>
</html>
<?php  } ?>