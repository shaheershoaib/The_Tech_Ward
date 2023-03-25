
<?php 

session_start();
if(empty($_SESSION['visited']))
{
$_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];
header("Location: ../login/logincheck.php"); 
}
else{
unset($_SESSION['visited']);



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
if($error != null){
  $output = "<p>Unable to connect to database!</p>";
  exit($output);
}
else{
    $email = $_POST["email"];
    $password = md5($_POST["password"]);

     $ds = "SELECT discussionId, title, email FROM discussion;";
     $result = mysqli_query($connection, $ds);
}



?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="../../css/project.css">
    <link rel="stylesheet" href="../../css/nav.css">
<style>
  .discussionList{
   margin-top: 200px;
   width: 75%
   display: flex;
   justify-content: center;
   flex-direction: column;
  
  
  }

  nav{
    position: fixed;
    top: 0;
  left: 0;
  right: 0;
  height: 100px;
  }
</style>

  </head>
  <body>

  <nav>

        <div class="logo"> <img src="../../images/logo.png" width="100" height="100"> </div>
        <div class="n"><div class="text"><p> The Tech Ward</p></div>
            <ul>
              <li><a href="new_discussion.php">New Discussion</a></li>
                <li><a href="#">Search For Discussion</a></li>
                <li><a href="#">Account</a></li>
                <li><a href="../login/logout.php">Logout</a></li> 
              </ul>
            </nav>


    <div class = "discussionList">


<?php  

while ($row = $result->fetch_assoc()) {
  echo "<a href = discussion.php?discussionId=".$row["discussionId"]."> Title: ".$row["title"]."<br> User:".$row["email"]."</a><br><br>";
}

?>

         </div>

  </body>
</html>
<?php  } ?>