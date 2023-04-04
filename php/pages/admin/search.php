<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use db\dbConnection;

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
$error = $dbConnection->getError();

$search = $_GET["search"];
$by = $_GET["by"];

if($by == "Name")
    $sql = "SELECT fullname, email FROM user WHERE fullname LIKE '$search%'";
else if($by == "Email")
    $sql = "SELECT fullname, email FROM user WHERE email LIKE '$search%'";
else
    $sql = "SELECT fullname, user.email FROM user, discussion WHERE discussion.email = user.email AND title LIKE '$search%'";

$result = mysqli_query($connection, $sql);
while($row = $result->fetch_assoc())
{
    echo "<div style = \"border: 4px solid black; width: 50%;\">";
    echo "<p> Full Name: ".$row["fullname"]."</p>";
    echo "<p> Email: ".$row["email"]."</p>";
    echo "</div>";
    echo "<br>";
}
    ?>