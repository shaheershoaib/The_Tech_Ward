<?php


use db\dbConnection;

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();
if(empty($_SESSION['visited']))
{
    $_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];
    header("Location: ../../login/logincheckadmin.php");
}
else {
    unset($_SESSION['visited']);
}


require_once '../../db/dbConnection.php';
$dbConnection = new dbConnection();
$connection = $dbConnection->getConnection();
$error = $dbConnection -> getError();

$email = $_GET["email"];
$disable = $_GET["disable"];

$toggleUser = "UPDATE user SET disabled = '$disable' WHERE email = '$email'";
mysqli_query($connection, $toggleUser);

header("Location: search_for_user.php");
?>