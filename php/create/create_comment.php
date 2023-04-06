<?php
//session_start();
use db\dbConnection;

require_once '../db/dbConnection.php';



if ($_SERVER['REQUEST_METHOD'] == "POST") {
      


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
    session_start();
    if(empty($_SESSION['email']))
    {
        header("Location: ../../html/login.html");
    }

    else
    {
    $body = $_POST["comment"];
    $discussionId = $_POST["discussionId"];
    $email = $_SESSION['email'];
                   
            try
            {
            $sql = "INSERT INTO comment(discussionId, body, email) VALUES('$discussionId', '$body', '$email');";
            $result = mysqli_query($connection, $sql);
            }
            catch(Exception $e)
            {
                echo 'Error: ' . $e->getMessage();
                exit();
            }

    
        header("Location: ../pages/discussion.php?discussionId={$discussionId}");


    mysqli_close($connection);
    exit();


    }
}


}

else
{
    die("Bad Request");
}

    
?>