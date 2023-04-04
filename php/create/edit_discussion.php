

<?php

use db\dbConnection;

session_start();
if(empty($_SESSION['visited'])){
$_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];
header("Location: ../login/logincheck.php"); 
}

else{
unset($_SESSION['visited']);
    require_once '../db/dbConnection.php';
    $dbConnection = new dbConnection();
    $connection = $dbConnection->getConnection();
    $error = $dbConnection->getError();
if($error != null){
  $output = "<p>Unable to connect to database!</p>";
  exit($output);
}

else{
 //Check if discussion belongs to the user


 //var_dump($_GET);

    $title= $_GET["title"];
    $desc = $_GET["desc"];
    $discussionId = $_GET["discussionId"]; 
    $updateStmt = "UPDATE discussion SET title = '$title', description = '$desc' WHERE discussionId = '$discussionId'";
    $updateResult = mysqli_query($connection, $updateStmt);
    header("Location: ../pages/my_discussions.php");
              
              
              
   
}

}
        
?>