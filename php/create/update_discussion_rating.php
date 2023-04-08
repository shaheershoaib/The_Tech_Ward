<?php

use db\dbConnection;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



session_start();


if (empty($_SESSION['visited'])) {
    if($_SERVER["REQUEST_METHOD"]!="POST")
    {
        echo "<p>Bad Request</p>";
        exit();
    }

    $_SESSION["discussionId"] = $_POST["discussionId"];
    $_SESSION["isLike"] = $_POST["isLike"];

    $_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];
    header("Location: ../login/logincheck.php");
} else {
    unset($_SESSION['visited']);
}

$discussionId = $_SESSION["discussionId"];
$isLike = $_SESSION["isLike"];
$email = $_SESSION["email"];

unset($_SESSION["discussionId"]);
unset($_SESSION["isLike"]);

require_once '../db/dbConnection.php';
$dbConnection = new dbConnection();
$connection = $dbConnection->getConnection();
$error = $dbConnection->getError();

$deleteCurrentRating = "DELETE FROM discussionRating WHERE email = '$email' AND discussionId = '$discussionId' ";
mysqli_query($connection, $deleteCurrentRating);

$newRating = "INSERT INTO discussionRating VALUES('$discussionId', '$email', '$isLike')";
mysqli_query($connection, $newRating);




?>