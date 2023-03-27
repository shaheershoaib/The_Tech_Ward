<?php
//session_start();


if ($_SERVER['REQUEST_METHOD'] == "GET") {
      


        // $host = "cosc360.ok.ubc.ca";
        // $database = "db_11505328";
        // $user = "11505328";
        // $password = "11505328";

        $host = "localhost";
        $database = "project";
        $user = "webuser";
        $password = "P@ssw0rd";
        
$connection = mysqli_connect($host, $user, $password, $database);
$error = mysqli_connect_error();
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
    $body = $_GET["comment"];
    $discussionId = $_GET["discussionId"];
    $email = $_SESSION['email'];
                   
            try
            {
            $sql = "INSERT INTO comment(discussionId, body, email, likeCount) VALUES('$discussionId', '$body', '$email', 0);";
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