

<?php
use db\dbConnection;

require_once '../db/dbConnection.php';

session_start();
if(empty($_SESSION['visited'])){
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
    session_start();
    parse_str($_SERVER['QUERY_STRING'], $params);
    $discussionId = $params['discussionId'];
    $email = $_SESSION['email'];
    $sql = "SELECT discussionId, email FROM discussion WHERE discussionId = '$discussionId'";
    $result = mysqli_query($connection, $sql);
    $row = $result->fetch_assoc();
    if(strcmp($email, $row["email"]) === 0)
    {
        $deleteStmt = "DELETE FROM discussion WHERE discussionId = '$discussionId'";
        $deleteResult = mysqli_query($connection, $deleteStmt);
        header("Location: ../pages/my_discussions.php");
                
    }
    
    else {
        $err_message = "<p>Sorry, you cannot delete a discussion that was not created by you.</p>";
        exit($err_message);
    }
    
}

}
        
?>