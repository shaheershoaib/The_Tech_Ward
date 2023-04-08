

<?php
use db\dbConnection;

require_once '../db/dbConnection.php';

session_start();
if(empty($_SESSION['visited'])){
    if($_SERVER["REQUEST_METHOD"] != "POST")
    {
        echo "<p>Bad Request</p>";
        exit();
    }

    $_SESSION["discussionId"] = $_POST["discussionId"];

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

    $discussionId = $_SESSION['discussionId'];
    unset($_SESSION['discussionId']);
    $email = $_SESSION['email'];
    $sql = "SELECT discussionId, email FROM discussion WHERE discussionId = '$discussionId'";
    $result = mysqli_query($connection, $sql);
    $row = $result->fetch_assoc();
    if(strcmp($email, $row["email"]) === 0 || !empty($_SESSION['admin']))
    {
        $deleteStmt = "DELETE FROM discussion WHERE discussionId = '$discussionId'";
        $deleteResult = mysqli_query($connection, $deleteStmt);
        $file =  basename($_SERVER["HTTP_REFERER"]);
        header("Location: ../pages/".$file);

                
    }
    
    else {
        $err_message = "<p>Sorry, you cannot delete a discussion that was not created by you.</p>";
        exit($err_message);
    }
    
}

}
        
?>