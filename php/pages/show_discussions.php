

<?php
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

    $ds = "SELECT discussionId, title, fullname FROM discussion, user WHERE discussion.email = user.email";
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

footer{
    position: fixed;
    left: 0;
  bottom: 0;
  height: 100px;
  }
</style>

  </head>
  <body>

  <nav>

        <div class="logo">  <a href = "show_discussions.php"><img src="../../images/logo.png" width="100" height="100"></a> </div>
        <div class="n"><div class="text"> <a href = "show_discussions.php"><p> The Tech Ward</p> <a href = "show_discussion.php"></div>
            <ul>
              <li><a href="new_discussion.php">New Discussion</a></li>
                <li><a href="#">Search For Discussion</a></li>
                <li><a href= "account.php">Account</a></li>
                <li><a href="../login/logout.php">Logout</a></li> 
              </ul>
            </nav>


    <div class = "discussionList">


<?php  

while ($row = $result->fetch_assoc()) {
  echo "<a href = discussion.php?discussionId=".$row["discussionId"]."> <h3> Title: ".$row["title"]." </h3> <br> User:".$row["fullname"]."</a><br><br>";
}

?>

         </div>

         <footer>
            <a href="#">Home</a> | <a href="#">Browse</a> | <a href="#">Search</a><br><br>
            <small><i>Copyright &copy; 2023 The Tech Ward</i></small>
        </footer>

  </body>
</html>
