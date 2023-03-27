

<?php

session_start();
if(empty($_SESSION['visited'])){
$_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];
header("Location: ../login/logincheck.php"); 
}

else{
unset($_SESSION['visited']);
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
 //Check if discussion belongs to the user


 //var_dump($_GET);


    $comment= $_GET["comment"];
    $commentId = $_GET["commentId"];
    $discussionId = $_GET["discussionId"]; 
    $updateStmt = "UPDATE comment SET body = '$comment' WHERE commentId = '$commentId'";
    $updateResult = mysqli_query($connection, $updateStmt);
    header("Location: ../pages/discussion.php?discussionId={$discussionId}");
 }

}


        
?>