<?php

use db\dbConnection;

ini_set('display_errors', 1); // Enable displaying errors
ini_set('display_startup_errors', 1); // Enable displaying startup errors
error_reporting(E_ALL); // Set the

session_start();

if (empty($_SESSION['visited'])) {

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        echo "<p> Bad request </p>";
        exit();
    }

    $_SESSION["discussionId"] = $_POST["discussionId"];
    $_SESSION["title"] = $_POST["title"];
    $_SESSION["desc"] = $_POST["desc"];
    $_SESSION["file"] = $_FILES;

    $_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];
    header("Location: ../login/logincheck.php");
} else {
    unset($_SESSION['visited']);
    require_once '../db/dbConnection.php';
    $dbConnection = new dbConnection();
    $connection = $dbConnection->getConnection();
    $error = $dbConnection->getError();

    if ($error != null) {
        $output = "<p>Unable to connect to database!</p>";
        exit($output);
    }
        //Check if discussion belongs to the user
        $email = $_SESSION['email'];
        $discussionId = $_SESSION["discussionId"];
        $title = $_SESSION["title"];
        $desc = $_SESSION["desc"];
        $filearray = $_SESSION["file"];

        unset($_SESSION['discussionId']);
        unset($_SESSION['title']);
        unset($_SESSION['desc']);
        unset($_SESSION["file"]);


            $sql = "SELECT * FROM user, discussion WHERE user.email = discussion.email AND user.email = '$email' AND discussionId = '$discussionId'";
            $result = mysqli_query($connection, $sql);

            if (($row = $result->fetch_assoc()) || !empty($_SESSION['admin'])) { // If there is a row, then that means the current discussionId belongs to the currently logged-in user
                //Or, if this is the admin

                if ($filearray['image']['error'] === UPLOAD_ERR_OK) {

                    $file_contents = file_get_contents($filearray['image']['tmp_name']);
                    $image = mysqli_escape_string($connection, $file_contents);
                    $fileName = basename($filearray["image"]["name"]);
                    $contentType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $sql = "UPDATE discussion SET title = '$title', description = '$desc', image = '$image', contentType = '$contentType' WHERE discussionId = '$discussionId'";
                    mysqli_query($connection, $sql);
                    header("Location: ../pages/show_discussions.php");
                    exit();
                }

                else {
                    $updateStmt = "UPDATE discussion SET title = '$title', description = '$desc' WHERE discussionId = '$discussionId'";
                    $updateResult = mysqli_query($connection, $updateStmt);
                    header("Location: ../pages/show_discussions.php");

                }
            }
}

?>
