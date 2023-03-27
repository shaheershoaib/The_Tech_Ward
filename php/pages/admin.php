<?php 

session_start();
if(empty($_SESSION['visited']) || empty($_SESSION['admin']))
{
$_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];
header("Location: ../login/logincheckadmin.php"); 
}
else{
unset($_SESSION['visited']);
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
       

        footer{
            position: fixed;
        }
    </style>
    
</head>
<body>
   

    
<header>
   <nav>
        <div class="logo"> <a href = "show_discussions.php"> <img src="../../images/logo.png" width="100" height="100"></a> </div>
        <div class="n"><div class="text">  <a href = "show_discussions.php"><p> The Tech Ward</p> </a></div>
        <?php $_SESSION['prev_page'] = $_SERVER['REQUEST_URI']; ?>
            <ul><li><a href="../login/logincheck.php">New Discussion</a></li>
                <li><a href="#">Search For Discussion</a></li>
                <li><a href="account.php">Account</a></li>
                <li><a href="admin.php">Admin</a></li> 
                <li><a href="../login/logout.php">Logout</a></li> </ul></div></nav>
                

</header> 
<br><br><br><br><br><br><br><br>

<h1> You have admin privilages</h1>
<br>
<h2> Admin login check is done and non admins cannot acesses this page.</h2>
<br>
<h3> All other admin privilages will be implemented in next milstone.</h3>


    </div>
        <footer>
            <a href="#">Home</a> | <a href="#">Browse</a> | <a href="#">Search</a><br><br>
            <small><i>Copyright &copy; 2023 The Tech Ward</i></small>
        </footer>
     
</body>
</html>