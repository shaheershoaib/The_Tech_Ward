<?php
//session_start();
use db\dbConnection;

require_once '../db/dbConnection.php';


if($_SERVER['REQUEST_METHOD'] == "POST") {
    if(empty($_POST["title"]) || empty($_POST["desc"]))
        die("Input fields are missing");

    $dbConnection = new dbConnection();
    $connection = $dbConnection->getConnection();
    $error = $dbConnection->getError();

if($error != null)
{
  $output = "<p>Unable to connect to database!</p>";
  exit($output);
}

    $title= $_POST["title"];
    $desc = $_POST["desc"];
    session_start();
    if(empty($_SESSION['email'])) {
        header("Location: ../../html/login.html");
        exit();
    }


        $email = $_SESSION['email'];
        
         
       if($_FILES['image']['error'] === UPLOAD_ERR_OK ) {
             $file_contents = file_get_contents($_FILES['image']['tmp_name']);
            $image = mysqli_escape_string($connection, $file_contents);
            $contentType = strtolower( pathinfo(basename($_FILES['image']['name']), PATHINFO_EXTENSION  )  );
            $sql = "INSERT INTO discussion (email, title, description, image, contentType) VALUES ('$email', '$title', '$desc', '$image', '$contentType')";
            mysqli_query($connection, $sql);
            header("Location: ../pages/show_discussions.php");
            exit();
     
     }
    
        else {
            $sql = "INSERT INTO discussion(email, title, description) VALUES('$email', '$title', '$desc');";
            $result = mysqli_query($connection, $sql);
            header("Location: ../pages/show_discussions.php");
        }

    
    mysqli_close($connection);
    exit();


}


else
    die("Bad Request");


    
?>
