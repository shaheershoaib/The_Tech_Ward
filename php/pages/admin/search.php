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
    $sql = "SELECT fullname, email, disabled FROM user WHERE fullname LIKE '$search%'";
else if($by == "Email")
    $sql = "SELECT fullname, email, disabled FROM user WHERE email LIKE '$search%'";
else
    $sql = "SELECT DISTINCT fullname,user.email, disabled FROM user, discussion WHERE discussion.email = user.email AND title LIKE '$search%'";

$result = mysqli_query($connection, $sql);
while($row = $result->fetch_assoc())
{
    $email = $row["email"];
    $disabled = $row["disabled"];
    echo "<div style = \"border: 4px solid black; width: 50%;\">";
    echo "<p> Full Name: ".$row["fullname"]."</p>";
    echo "<p> Email: ".$row["email"]."</p>";
   // echo "<button href = \"toggleUser.php?email=".$row["email"]."&disable=1\">Disable</button>";
    ?>

<?php if($email != "admin@admin.com"){ ?>
        <div email = <?php echo $email; ?> >
     <button class = "disableButton"  <?php if($disabled == 1) echo "disabled"; ?>>Disable</button>
     <button class = "enableButton" <?php if($disabled == 0) echo "disabled"; ?> >Enable</button>
            <?php } ?>
<?php
    echo "</div>";
    echo "<br>";
    echo "</div>";
}
    ?>

<script>

    $(".disableButton").on("click", function(){
        $.get("toggleUser.php", {email: $(this).parent().attr("email"), disable: 1}, function(){});

        $(this).siblings(".enableButton").removeAttr("disabled"); // Enable enableButton
        $(this).prop("disabled", true);
    });

    $(".enableButton").on("click", function(){
        $.get("toggleUser.php", {email: $(this).parent().attr("email"), disable: 0}, function(){});

        $(this).siblings(".disableButton").removeAttr("disabled", ""); // Enable enableButton
        $(this).prop("disabled", true);
    });

    </script>
