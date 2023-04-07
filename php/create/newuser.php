<?php

use db\dbConnection;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if(empty($_POST["fullname"]) || empty($_POST["email"]) || empty($_POST["password"])) {
        die("Input fields are missing");
      }else{

        require_once '../db/dbConnection.php';
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
    $fullname = $_POST["fullname"];
     $email = $_POST["email"];
    $password = md5($_POST["password"]);

     $ds = "SELECT * FROM user where email = '$email'; ";
     $result = mysqli_query($connection, $ds);
    if (mysqli_fetch_assoc($result)) {
      echo "The user with same email already exists";
      echo "<br>";
      echo "<a href =".$_SERVER['HTTP_REFERER']." > Return to user entry </a>";
   }
   else{


    if($_FILES['image']['error'] === UPLOAD_ERR_OK ) {
           $dir = "pp/";
            $file = $dir . basename($_FILES["image"]["name"]);
            $flag = 1;
            $flag2 = 0;
            $imageFileType = strtolower(pathinfo($file,PATHINFO_EXTENSION));
            $fileName = $_FILES['image']['name'];
     
     
     
     
     
           //  if (file_exists($file)) {
           //   echo "<br>Duplicate file entry";
           //   $flag = 0;
           // }
     
           if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif" && $imageFileType != "jpeg" ) {
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
     
     
     
     
     
     
     
        
     
     }
     
     if($flag2 == 1){
      $imagedata = file_get_contents("pp/".$fileName);
      $sql1 = "INSERT INTO user (fullname, email, password, pfp, contentType) VALUES('$fullname', '$email',  '$password', ?,?);";
      $stmt = mysqli_stmt_init($connection); 
      mysqli_stmt_prepare($stmt, $sql1); 
      $null = NULL;
      mysqli_stmt_bind_param($stmt, "bs", $null, $imageFileType);
      mysqli_stmt_send_long_data($stmt, 0, $imagedata);
      $resultt = mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));
      header("Location: ../../html/login.html");
      
      }
     
 }
else{
        $statement = "INSERT INTO user (fullname, email, password) VALUES ('$fullname', '$email',  '$password');";
        $r = mysqli_query($connection, $statement);
        if ($r) {
            
            header("Location: ../../html/login.html");
            exit();
        
        }
      }
    }
}
mysqli_free_result($r);

mysqli_close($connection);
}
}
else{
    die("Bad Request");
}
?>