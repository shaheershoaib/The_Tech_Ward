<!DOCTYPE html>
<html>
<body>

<?php
session_start();
//$_SESSION["email"] = null;
session_unset();
session_destroy();
header("Location: ../html/login.html");
exit();
?>

</body>
</html>