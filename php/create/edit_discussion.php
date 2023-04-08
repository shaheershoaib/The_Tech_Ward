<?php

use db\dbConnection;

session_start();
if($_SERVER["REQUEST_METHOD"] != "POST")
{
    echo "<p> Bad request </p>";
    exit();
}

$discussionId = $_POST["discussionId"];
$title = $_POST["title"];
$desc = $_POST["desc"];

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

    if($email!=null && ($discussionId!=null && $discussionId!= "") && ($title != null && $title!="") && ($desc !=null && $desc!= "")) {
        $sql = "SELECT * FROM user, discussion WHERE user.email = discussion.email AND user.email = '$email' AND discussionId = '$discussionId'";
        $result = mysqli_query($connection, $sql);

        if (($row = $result->fetch_assoc()) || !empty($_SESSION['admin'])) { // If there is a row, then that means the current discussionId belongs to the currently logged-in user
            //Or, if this is the admin
            
            if($_FILES['image']['error'] === UPLOAD_ERR_OK ) {
                
        //         $dir = "pp/";
        //          $file = $dir . basename($_FILES["image"]["name"]);
        //          $flag = 1;
        //          $flag2 = 0;
        //          $imageFileType = strtolower(pathinfo($file,PATHINFO_EXTENSION));
        //          $fileName = $_FILES['image']['name'];
          
          
          
          
          
        //         //  if (file_exists($file)) {
        //         //   echo "<br>Duplicate file entry";
        //         //   $flag = 0;
        //         // }
          
        //         if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif" && $imageFileType != "jpeg" ) {
        //         echo "<br>Cannot support the uploaded file format.";
        //         $flag = 0;
        //        }
          
        //        if ($_FILES["image"]["size"] > 500000) {
        //         echo "<br>File too large.Max file size is 100K";
        //         $flag = 0;
        //       }
          
          
          
          
        //        if ($flag == 0) {
        //         echo "Sorry, your file was not uploaded.";
           
        //       } else {
        //         if (move_uploaded_file($_FILES["image"]["tmp_name"], $file)) {
                  
                 
        //           $flag2 = 1;
        //         } else {
        //           echo "<br> Error Uploading the file";
        //         }
          
          
          
          
          
          
          
             
          
        //   }
          
        //   if($flag2 == 1){
        //    $imagedata = file_get_contents("pp/".$fileName);
        //    $sql1 = "INSERT INTO user (fullname, email, password, pfp, contentType) VALUES('$fullname', '$email',  '$password', ?,?);";
        //    $stmt = mysqli_stmt_init($connection); 
        //    mysqli_stmt_prepare($stmt, $sql1); 
        //    $null = NULL;
        //    mysqli_stmt_bind_param($stmt, "bs", $null, $imageFileType);
        //    mysqli_stmt_send_long_data($stmt, 0, $imagedata);
        //    $resultt = mysqli_stmt_execute($stmt) or die(mysqli_stmt_error($stmt));
        //    header("Location: ../../html/login.html");
           
        //    }
          
      } else{
        $updateStmt = "UPDATE discussion SET title = '$title', description = '$desc' WHERE discussionId = '$discussionId'";
        $updateResult = mysqli_query($connection, $updateStmt);
        header("Location: ../pages/my_discussions.php");
      }

          
    }

    }
    else echo "<p>Incomplete information</p>";
   
}

}
        
?>



