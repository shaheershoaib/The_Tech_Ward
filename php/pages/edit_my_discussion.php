

<?php 
use db\dbConnection;

require_once '../db/dbConnection.php';
session_start();
if(empty($_SESSION['visited']))
{
$_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];
header("Location: ../login/logincheck.php"); 
}
else{
unset($_SESSION['visited']);

$dbConnection = new dbConnection();
$connection = $dbConnection->getConnection();
$error = $dbConnection->getError();
if($error != null){
  $output = "<p>Unable to connect to database!</p>";
  exit($output);
}
else{


    session_start();
    parse_str($_SERVER['QUERY_STRING'], $params);
    $discussionId = $params['discussionId'];
    $email = $_SESSION['email'];
    $sql = "SELECT user.email, title, description FROM discussion, user WHERE user.email = discussion.email AND user.email = '$email' AND discussionId = '$discussionId'";
    $result = mysqli_query($connection, $sql);
    $row = $result->fetch_assoc();
    if(strcmp($email, $row["email"]) !== 0)
     {
        $err_message = "<p>Sorry, you cannot edit a discussion that was not created by you.</p>";
        exit($err_message);
                 
     }
           

}

?>



<!DOCTYPE html>
<html>


<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../css/project.css">
    <link rel="stylesheet" href="../../css/nav.css">


    <title> Edit My Discussion </title>

    <style>
        .wrapper{
            display: flex;
            width: 100%;
            height: 100%;
            justify-content: center;
            align-items: center;
        }

        footer{
            position: fixed;
        }
    </style>
    
</head>
<body>
   

    
<header>
   <nav>
        <div class="logo"> <a href = "show_discussions.php"> <img src="../../Images/logo.png" width="100" height="100"></a> </div>
        <div class="n"><div class="text">  <a href = "show_discussions.php"><p> The Tech Ward</p> </a></div>
        <?php $_SESSION['prev_page'] = $_SERVER['REQUEST_URI']; ?>
            <ul><li><a href="../login/logincheck.php">New Discussion</a></li>
                <li><a href="#">Search For Discussion</a></li>
                <li><a href="account.php">Account</a></li>
                <li><a href="admin/admin.php">Admin</a></li>
                <li><a href="../login/logout.php">Logout</a></li> </ul></div></nav>

</header> 

<div class = "wrapper">
    <div class="lform">
        <h1>Edit Your Discussion</h1>
        <form align="center" method="get" action="../create/edit_discussion.php">
            <label for="title">Title:</label>
            <input type="text" name="title"  required id="title" value = "<?php echo $row["title"];?>" >
            <br><br>
            <label for="description">Description:</label>
            <textarea name="desc" required id="description"><?php echo $row["description"]; ?></textarea>
            <br><br>
            <label for="image">Upload Image (optional) : </label>
            <input type="file" id="image" name="image" accept="image/png, image/jpeg" enctype="multipart/form-data">
            <input type="hidden" name="discussionId" value="<?php echo $discussionId; ?>">
         <br><br>
            <button type="reset">Clear Discussion</button>
            <button type="submit">Save Edit</button>
        </form>

    </div>
    </div>
        <footer>
            <a href="#">Home</a> | <a href="#">Browse</a> | <a href="#">Search</a><br><br>
            <small><i>Copyright &copy; 2023 The Tech Ward</i></small>
        </footer>
     
</body>
</html>

<?php  } ?>