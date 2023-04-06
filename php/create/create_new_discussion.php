<?php
//session_start();
use db\dbConnection;

require_once '../db/dbConnection.php';


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if(empty($_POST["title"]) || empty($_POST["desc"])) {
        die("Input fields are missing");
      }else{


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
    $title= $_POST["title"];
    $desc = $_POST["desc"];
    session_start();
    if(empty($_SESSION['email']))
    {
        header("Location: ../../html/login.html");
    }
   
    else
    {
        $email = $_SESSION['email'];
        
         
       if($_FILES['image']['error'] === UPLOAD_ERR_OK )
       //if(isset($_FILES['image']))

        {












            // $file_contents = file_get_contents($_FILES['image']['tmp_name']);
            // $sql = "INSERT INTO discussion(email, title, description, image) VALUES('$email', '$title', '$desc', '$file_contents');";
            // $result = mysqli_query($connection, $sql);


            $dir = "uploads/";
            $file = $dir . basename($_FILES["image"]["name"]);
            $flag = 1;
            $flag2 = 0;
            $imageFileType = strtolower(pathinfo($file,PATHINFO_EXTENSION));
            $fileName = $_FILES['image']['name'];
     
     
     
     
     
           //  if (file_exists($file)) {
           //   echo "<br>Duplicate file entry";
           //   $flag = 0;
           // }
     
           if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif" ) {
           echo "<br>Cannot support the uploaded file format.";
           $flag = 0;
          }
     
          if ($_FILES["image"]["size"] > 500000) {
           echo "<br>File too large.Max file size is 100K";
           $flag = 0;
         }
     
     
     
     
          if ($flag == 0) {
           echo "Sorry, your file was not uploaded.";
      
         } else {
           if (move_uploaded_file($_FILES["image"]["tmp_name"], $file)) {
             
            
             $flag2 = 1;
           } else {
             echo "<br> Error Uploading the file";
           }
     
     
     
     
     
     
     
        //    $statement2 = "SELECT userID from users where username = '$username'; ";
        //    $r2 = mysqli_query($connection, $statement2);
        //    if ($rr = mysqli_fetch_assoc($r2)) {
        //    $userID = $rr['userID'];
        //    }
     
     }
     
     
     
     
        
     if($flag2 == 1){
     $imagedata = file_get_contents("uploads/".$fileName);
     $sql1 = "INSERT INTO discussion(email, title, description, image, contentType) VALUES(?,?,?,?,?);";
     $stmt = mysqli_stmt_init($connection); 
     mysqli_stmt_prepare($stmt, $sql1); 
     $null = NULL;
     mysqli_stmt_bind_param($stmt, "sssbs", $email, $title, $desc,$null, $imageFileType);
     mysqli_stmt_send_long_data($stmt, 3, $imagedata);
     $resultt = mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));
     
     }
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     













































































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
    
        header("Location: ../pages/show_discussions.php");

    
    mysqli_close($connection);
    exit();

    }
}


}

}


else
{
    die("Bad Request");
}

    
?>