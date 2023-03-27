<?php

      


        $host = "cosc360.ok.ubc.ca";
        $database = "db_11505328";
        $user = "11505328";
        $password = "11505328";

        // $host = "localhost";
        // $database = "project";
        // $user = "webuser";
        // $password = "P@ssw0rd";
        
$connection = mysqli_connect($host, $user, $password, $database);
$error = mysqli_connect_error();
if($error != null)
{
  $output = "<p>Unable to connect to database!</p>";
  exit($output);
}
else
{
   
    $fullname = "Admin";
    $email = "admin@admin.com";
    $admin = true;
    $password = md5("Admin@12345");

                   
            try
            {
            $sql = "INSERT INTO user(fullname, email, password, admin) VALUES('$fullname', '$email', '$password', '$admin');";
            $result = mysqli_query($connection, $sql);
            }
            catch(Exception $e)
            {
                echo 'Error: ' . $e->getMessage();
                exit();
            }

            
           
        
        
    
        header("Location: ../html/login.html");


    mysqli_close($connection);
    exit();


    }







    
?>