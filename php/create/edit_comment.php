

<?php

use db\dbConnection;

session_start();


if(empty($_SESSION['visited'])){
    if($_SERVER["REQUEST_METHOD"] != "POST")
    {
        echo "<p>Bad Request</p>";
        exit();
    }

    $_SESSION["comment"] = $_POST["comment"];
    $_SESSION["commentId"] = $_POST["commentId"];
    $_SESSION["discussionId"] = $_POST["discussionId"];

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


    $comment= $_SESSION["comment"];
    $commentId = $_SESSION["commentId"];
    $discussionId = $_SESSION["discussionId"];

    unset($_SESSION["comment"]);
    unset($_SESSION["commentId"]);
    unset($_SESSION["discussionId"]);

    if( ($comment!=null && $comment!= "") && ($commentId!=null && $commentId!="") && ($discussionId != null && $discussionId != "")) {

        $sql = "SELECT * FROM user, comment WHERE comment.email = user.email AND commentId = '$commentId'";
        $result = mysqli_query($connection, $sql);

        if( ($row = $result->fetch_assoc()) || !empty($_SESSION['admin'])) {
            $updateStmt = "UPDATE comment SET body = '$comment' WHERE commentId = '$commentId'";
            $updateResult = mysqli_query($connection, $updateStmt);
            header("Location: ../pages/discussion.php?discussionId={$discussionId}");
        }
    }
    else echo "<p>Incomplete information.</p>";

 }

}


        
?>