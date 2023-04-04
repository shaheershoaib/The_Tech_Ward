<?php


use db\dbConnection;

session_start();
if (empty($_SESSION['visited'])) {
    $_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];
    header("Location: ../login/logincheck.php");
} else {
    unset($_SESSION['visited']);
}





require_once '../db/dbConnection.php';
$dbConnection = new dbConnection();
$connection = $dbConnection->getConnection();
$error = $dbConnection->getError();

$search = $_GET["search"];


$sql = "SELECT discussionId, title, fullname, user.email FROM discussion, user WHERE discussion.email = user.email AND title LIKE '$search%'";

$result = mysqli_query($connection, $sql);
while ($row = $result->fetch_assoc()) {
    echo "<a href = discussion.php?discussionId=".$row["discussionId"]."> <h3> Title: ".$row["title"]." </h3> <br> User:".$row["fullname"]."</a>";
    session_start();
    if($_SESSION["admin"] || $row["email"] == $_SESSION['email']) {
        echo "<a href='../create/delete_discussion.php?discussionId=" . $row["discussionId"] . "'><button>Delete</button></a>";
        echo "<a href='edit_my_discussion.php?discussionId=" . $row["discussionId"] . "'><button>Edit</button></a>";
    }
}


?>