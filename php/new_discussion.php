<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if(empty($_POST["title"]) || empty($_POST["desc"])) {
        die("Input fields are missing");
      }else{


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
    $title= $_POST["title"];
    $desc = $_POST["desc"];
    session_start();
    if(empty($_SESSION['email']))
    {
        header("Location: ../html/login.html");
    }
   
    else
    {
        $email = $_SESSION['email'];
        
         
        if($_FILES['image']['error'] === UPLOAD_ERR_OK )
        {
            $file_contents = file_get_contents($_FILES['image']['tmp_name']);
            $sql = "INSERT INTO discussion(email, title, description, image) VALUES('$email', '$title', '$desc', '$file_contents');";
            $result = mysqli_query($connection, $sql);
        }

    
        else
        {

           
            try
            {
            $sql = "INSERT INTO discussion(email, title, description) VALUES('$email', '$title', '$desc');";
            $result = mysqli_query($connection, $sql);
            }
            catch(Exception $e)
            {
                echo 'Error: ' . $e->getMessage();
                exit();
            }

           
        
        }
    
        header("Location: ../html/discussion.html");

    
    exit();
    mysqli_close($connection);

    }
}


}

}


else
{
    die("Bad Request");
}
?>