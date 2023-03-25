<!DOCTYPE html>
<html>
<body>

<?php
session_unset();
session_destroy();
header("Location: ../html/login.html");
exit();
?>

</body>
</html>