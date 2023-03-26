<?php
session_start();

if(empty($_SESSION['email']))
{
    header("Location: ../../html/login.html");
    exit();
}
else{

   if(empty($_SESSION['prev_page']))
        header("Location: ../pages/show_discussions.php");
    else {
    $prev_page =  $_SESSION['prev_page'];
    unset($_SESSION['prev_page']);
    header("Location: {$prev_page}");
    $_SESSION['visited'] = 1;
    }
    exit();
}

?>
