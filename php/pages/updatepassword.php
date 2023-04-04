

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

<script>
       window.onload = function()
{
    var form  = document.getElementById("mainform");
    form.onsubmit = function(e)
    {
          var p1 = document.getElementById("pass");
          var p2 = document.getElementById("cpass");
          if (p1.value !== p2.value) {
            alert("Password's do not match!!");
            e.preventDefault();
    
          }
          else{
            var form = document.getElementById("mainform");
            form.setAttribute("method", "post");
          }
        }
        }
        
      </script>
    
</head>
<body>
   

    
<header>
   <nav>
        <div class="logo">  <a href = "show_discussions.php"><img src="../../Images/logo.png" width="100" height="100">  </a> </div>
        <div class="n"><div class="text"> <a href = "show_discussions.php"><p> The Tech Ward</p></a></div>
        <?php $_SESSION['prev_page'] = $_SERVER['REQUEST_URI']; ?>
            <ul><li><a href="new_discussion.php">New Discussion</a></li>
                <li><a href="#">Discussions</a></li>
                <li><a href="account.php">Account</a></li>
                <li><a href="admin/admin.php">Admin</a></li>
                <li><a href="../login/logout.php">Logout</a></li> </ul></div></nav>

</header> 

<div class = "wrapper">
    <div class="lform">
        <h1>Update Password</h1>
        <form align="center" method="post" action="../login/update_password_check.php" id = "mainform">
            <label for="oldpass">Old Password:</label>
            <input type="password" name="oldpass"  required id="oldpass">
            <br><br>
            <label for="pass">New Password:</label>
            <input type="password" name="pass"  required id="pass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
            <br><br>
            <label for="cpass">New Password:</label>
            <input type="password" name="cpass"  required id="cpass">
         <br><br>
            <button type="reset">Clear</button>
            <button type="submit">Change</button>
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