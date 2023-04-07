<?php 

session_start();
if(empty($_SESSION['visited']))
{
$_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];
header("Location: ../../login/logincheckadmin.php");
}
else{
unset($_SESSION['visited']);
}
?>


<!DOCTYPE html>
<html>

<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../../css/project.css">


    <title> Edit My Discussion </title>

    <style>
       

        footer{
            position: fixed;
        }
    </style>
    
</head>
<body>
   

    
<header>
   <nav>
        <div class="logo"> <a href = "../show_discussions.php"> <img src="../../../Images/logo.png" width="100" height="100"></a> </div>
        <div class="n"><div class="text">  <a href = "../show_discussions.php"><p> The Tech Ward</p> </a></div>
        <?php $_SESSION['prev_page'] = $_SERVER['REQUEST_URI']; ?>
            <ul><li><a href="../new_discussion.php">New Discussion</a></li>
                <li><a href="../show_discussions.php">Discussions</a></li>
                <li><a href="../account.php">Account</a></li>
                <li><a href="admin.php">Admin</a></li>
                <li><a href="search_for_user.php">Search For User</a></li>
                <li><a href="../../login/logout.php">Logout</a></li> </ul></div></nav>
                

</header> 
<br><br><br><br><br><br><br><br>

<h1>Welcome, Admin</h1>
<h2> You have administrative privileges</h2>
<h2>You may: </h2>
<ul>
    <li>
        <h3> &nbsp; &nbsp; &nbsp;Search for user by name, email, and post </h3>
    </li>
    <li>
        <h3> &nbsp;&nbsp;&nbsp;&nbsp; Edit and delete any discussion and comment </h3>
    </li>
    <li>
        <h3> &nbsp;&nbsp;&nbsp;&nbsp; Disable and enable users</h3>
    </li>
</ul>
<br>


    </div>
        <footer>
            <a href="#">Home</a> | <a href="#">Browse</a> | <a href="#">Search</a><br><br>
            <small><i>Copyright &copy; 2023 The Tech Ward</i></small>
        </footer>
     
</body>
</html>