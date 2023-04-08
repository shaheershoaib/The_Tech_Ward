

<?php
use db\dbConnection;

require_once '../db/dbConnection.php';

session_start();
if(empty($_SESSION['visited'])){
    if($_SERVER["REQUEST_METHOD"]!="POST")
    {
        echo "<p> Bad Request </p>";
        exit();
    }

    $_SESSION["commentId"] = $_POST["commentId"];
$_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];
header("Location: ../login/logincheck.php"); 
}

else{
unset($_SESSION['visited']);
$dbConnection = new dbConnection();
$connection = $dbConnection->getConnection();
$error = $dbConnection->getError();
if($error != null){
  $output = "<p>Unable to connect to database!</p>";
  exit($output);
}

else{
 //Check if discussion belongs to the user


    $commentId = $_SESSION['commentId'];
    unset($_SESSION["commentId"]);
    $email = $_SESSION['email'];

    $sql = "SELECT email, discussionId FROM comment WHERE commentId = '$commentId'";
    $result = mysqli_query($connection, $sql);
    $row = $result->fetch_assoc();
    if(strcmp($email, $row["email"]) === 0 || !empty($_SESSION['admin']))
    {
        $deleteStmt = "DELETE FROM comment WHERE commentId = '$commentId'";
        $deleteResult = mysqli_query($connection, $deleteStmt);
        header("Location: ../pages/discussion.php?discussionId=".$row["discussionId"]);

                
    }
    
    else {
        $err_message = "<p>Sorry, you cannot delete a comment that was not created by you.</p>";
        exit($err_message);
    }
    
}

}
        
?>