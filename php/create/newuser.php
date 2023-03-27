<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if(empty($_POST["fullname"]) || empty($_POST["email"]) || empty($_POST["password"])) {
        die("Input fields are missing");
      }else{


        $host = "cosc360.ok.ubc.ca";
        $database = "db_11505328";
        $user = "11505328";
        $password = "11505328";

// $host = "localhost";
// $database = "project";
// $user = "webuser";
// $password = "P@ssw0rd";



$connection = mysqli_connect($host, $user, $password, $database);
$error = mysqli_connect_error();
if($error != null)
{
  $output = "<p>Unable to connect to database!</p>";
  exit($output);
}
else
{
    $fullname = $_POST["fullname"];
     $email = $_POST["email"];
    $password = md5($_POST["password"]);

     $ds = "SELECT * FROM user where email = '$email'; ";
     $result = mysqli_query($connection, $ds);
    if (mysqli_fetch_assoc($result)) {
      echo "The user with same email already exists";
      echo "<br>";
      echo "<a href =".$_SERVER['HTTP_REFERER']." > Return to user entry </a>";
   }
   else{

        $statement = "INSERT INTO user (fullname, email, password) VALUES ('$fullname', '$email',  '$password');";
        $r = mysqli_query($connection, $statement);
        if ($r) {
            
            header("Location: ../../html/login.html");
            exit();
        
        }
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