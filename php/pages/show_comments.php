<?php


use db\dbConnection;

require_once '../db/dbConnection.php';
$dbConnection = new dbConnection();
$connection = $dbConnection->getConnection();
$error = $dbConnection->getError();
if($error!=null)
{
    exit($error);
}
$discussionId = $_GET["discussionId"];
$commentQuery = "SELECT commentId, comment.email as commentEmail, fullname, body, discussionId FROM user, comment WHERE user.email = comment.email AND comment.discussionId = '$discussionId'";
$result = mysqli_query($connection, $commentQuery);

while ($row = $result->fetch_assoc()) {
    echo "<div class = \"parent\" commentId = {$row['commentId']} discussionId = {$row['discussionId']}>";
    echo "<p>By: {$row['fullname']} </p>";
    echo "<div class = \"child\">";
    echo "<p>{$row['body']}</p>";
    session_start();
    if ((!empty($_SESSION['email']) && strcmp($row['commentEmail'], $_SESSION['email']) === 0) || !empty($_SESSION['admin'])) {
        echo "<button class = \"editButton\">Edit</button>";
        echo "<a href = \"../create/delete_comment.php?commentId={$row['commentId']}\"><button class = \"deleteButton\">Delete</button></a>";
    }
    echo "<br>";
    echo "</div>";
    echo "</div>";
}

// Support for comment


?>