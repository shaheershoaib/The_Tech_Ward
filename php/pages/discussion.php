<!DOCTYPE html>
<html>


<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../css/project.css">
    <link rel="stylesheet" href="../../css/nav.css">
    <link rel="stylesheet" href="../../css/discussion.css">
    

    <title> Discussion </title>
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
                <li><a href="../login/logout.php">Logout</a></li> </ul></div></nav>

</header> 
<br> <br>  <br> <br>  <br> <br>


<div class = "dis">

<?php

$host = "localhost";
$database = "project";
$user = "webuser";
$password = "P@ssw0rd";

// $host = "cosc360.ok.ubc.ca";
// $database = "db_11505328";
// $user = "11505328";
// $password = "11505328";
$connection = mysqli_connect($host, $user, $password, $database);
$error = mysqli_connect_error();
if($error != null){
  $output = "<p>Unable to connect to database!</p>";
  exit($output);
}
else{

    parse_str($_SERVER['QUERY_STRING'], $params);
    $discussionId = $params['discussionId'];


    $ds = "SELECT title, fullname, description FROM discussion, user WHERE discussion.email = user.email AND discussionId = '$discussionId'; ";
    $result = mysqli_query($connection, $ds);
    
    if ($row = mysqli_fetch_assoc($result)) {

        
        echo"<h1>".$row["title"]."</h1>";
        echo"<h3>By: ".$row["fullname"]."</h3>";
        echo "<br><br>";
        echo "<h4>".$row["description"]."</h4>";
        

      

?>
</div>
       

<div class = "comm">
  

        <h1>Post Your Comment Here:</h1>
        <form method = "GET" action = "../create/create_comment.php">   
        <textarea name = "comment" placeholder = "What are your thoughts?" required></textarea>
        <input name = "discussionId" type = "hidden" value = "<?php echo $discussionId ?>">
        <br>
        <button>Add Comment</button>
        </form>
        <br><br>
        <h1>Comments:<h1>

        </div>
        
    <?php
        $commentQuery = "SELECT fullname, body FROM user, comment WHERE user.email = comment.email AND comment.discussionId = '$discussionId'";
        $result = mysqli_query($connection, $commentQuery);

        while($row = $result->fetch_assoc())
        {
            echo"<p>By: {$row['fullname']} </p>";
            echo"<p>{$row['body']}</p>";
            echo "<br>";
        }

        // Support for comment

       
    ?>


        
        


<?php

    } else {
        // Discussion with provided ID does not exist
        echo "Discussion with ID $discussionId does not exist.";
    }
        
}



?>


<footer>
            <a href="#">Home</a> | <a href="#">Browse</a> | <a href="#">Search</a><br><br>
            <small><i>Copyright &copy; 2023 The Tech Ward</i></small>
        </footer>

</body>
</html>