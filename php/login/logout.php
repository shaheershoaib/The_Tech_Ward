<!DOCTYPE html>
<html>
<body>

<?php
session_start();
session_unset();
session_destroy();
header("Location: ../../html/login.html");
exit();
?>

</body>
</html>