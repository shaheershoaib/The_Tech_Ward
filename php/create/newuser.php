<?php

use db\dbConnection;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if(empty($_POST["fullname"]) || empty($_POST["email"]) || empty($_POST["password"])) {
        die("Input fields are missing");
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


    if($_FILES['image']['error'] === UPLOAD_ERR_OK ) {
          
         
     
      $file_contents = file_get_contents($_FILES['image']['tmp_name']);
      $image = mysqli_escape_string($connection, $file_contents);
      $contentType = strtolower( pathinfo(basename($_FILES['image']['name']), PATHINFO_EXTENSION  )  );
      $sql = "INSERT INTO user (fullname, email, password, pfp, contentType) VALUES('$fullname', '$email',  '$password', '$image', '$contentType');";
      mysqli_query($connection, $sql);
      header("Location: ../../html/login.html");
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
}
mysqli_free_result($r);

mysqli_close($connection);
}
}
else{
    die("Bad Request");
}
?>