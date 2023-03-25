<!DOCTYPE html>
<html>
<body>

<?php
session_start();

if(empty($_SESSION['email']))
{
    header("Location: ../html/login.html");
    exit();
}else{
   
    header("Location: ../html/new_discussion.html");
    exit();
}


?>

</body>
</html>