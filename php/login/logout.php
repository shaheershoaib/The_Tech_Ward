

<?php
session_start();
if(!empty($_SESSION['username'])) {
    session_destroy();
    header("Location: logout.php");
}
else header("Location: ../../html/login.html");
exit();
?>

