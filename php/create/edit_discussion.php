

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
    $email = $_SESSION['email'];
    $discussionId = $_GET["discussionId"];
    $title = $_GET["title"];
    $desc = $_GET["desc"];

    if($email!=null && ($discussionId!=null && $discussionId!= "") && ($title != null && $title!="") && ($desc !=null && $desc!= "")) {
        $sql = "SELECT * FROM user, discussion WHERE user.email = discussion.email AND user.email = '$email' AND discussionId = '$discussionId'";
        $result = mysqli_query($connection, $sql);

        if (($row = $result->fetch_assoc()) || !empty($_SESSION['admin'])) { // If there is a row, then that means the current discussionId belongs to the currently logged-in user
            //Or, if this is the admin


            $updateStmt = "UPDATE discussion SET title = '$title', description = '$desc' WHERE discussionId = '$discussionId'";
            $updateResult = mysqli_query($connection, $updateStmt);
            header("Location: ../pages/my_discussions.php");
        }

    }
    else echo "<p>Incomplete information</p>";
   
}

}
        
?>