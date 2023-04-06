

<?php 

session_start();
if(empty($_SESSION['visited']))
{
$_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];
header("Location: ../login/logincheck.php"); 
}
else{
unset($_SESSION['visited']);
?>

<!DOCTYPE html>
<html>


<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../css/project.css">
    <link rel="stylesheet" href="../../css/nav.css">


    <title> Login </title>

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
        <div class="logo"><a href = "show_discussions.php"> <img src="../../Images/logo.png" width="100" height="100"> </a></div>
        <div class="n"><div class="text"><a href = "show_discussions.php"><p> The Tech Ward</p></a></div>
        <?php $_SESSION['prev_page'] = $_SERVER['REQUEST_URI']; ?>
            <ul><li><a href="new_discussion.php">New Discussion</a></li>
                <li><a href="show_discussions.php">Discussions</a></li>
                <li><a href="account.php">Account</a></li>
               
                <?php if(!empty($_SESSION['admin'])) { ?>
                <li><a href="admin/admin.php">Admin</a></li>
                <li><a href="admin/search_for_user.php">Search For User</a></li>
                <?php } ?>
                <li><a href="../login/logout.php">Logout</a></li> </ul></div></nav>

</header> 

<div class = "wrapper">
    <div class="lform">
        <h1>Create a Discussion</h1>
        <form align="center" method="post" action="../create/create_new_discussion.php" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" name="title"  required id="title">
            <br><br>
            <label for="description">Description:</label>
            <textarea name="desc" required id="description"></textarea>
            <br><br>
            <label for="image">Upload Image (optional) : </label>
            <input type="file" id="image" name="image">
         <br><br>
            <button type="reset">clear form</button>
            <button type="submit">post</button>
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