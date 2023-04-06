<!DOCTYPE html>
<html>


<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../css/project.css">
    <link rel="stylesheet" href="../../css/nav.css">
    <link rel="stylesheet" href="../../css/discussion.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


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
        <div class="logo"> <a href = "show_discussions.php"> <img src="../../Images/logo.png" width="100" height="100"></a> </div>
        <div class="n"><div class="text">  <a href = "show_discussions.php"><p> The Tech Ward</p> </a></div>
        <?php $_SESSION['prev_page'] = $_SERVER['REQUEST_URI']; ?>
            <ul><li><a href="new_discussion.php">New Discussion</a></li>
                <li><a href="show_discussions.php">Discussions</a></li>
                <li><a href="account.php">Account</a></li>
               
                <?php session_start(); if(!empty($_SESSION['admin'])) {?>
                <li><a href="admin/admin.php">Admin</a></li>
                <li><a href="admin/search_for_user.php">Search For User</a></li>
                <?php } ?>
                <li><a href="../login/logout.php">Logout</a></li> </ul></div></nav>

</header> 
<br> <br>  <br> <br>  <br> <br>



<?php

use db\dbConnection;

require_once '../db/dbConnection.php';


$dbConnection = new dbConnection();
$connection = $dbConnection->getConnection();
$error = $dbConnection->getError();
$flag = 0;
if($error != null){
  $output = "<p>Unable to connect to database!</p>";
  exit($output);
}
else{

    parse_str($_SERVER['QUERY_STRING'], $params);
    $discussionId = $params['discussionId'];


    


    $ds = "SELECT title, fullname, description, image,  contentType FROM discussion, user WHERE discussion.email = user.email AND discussionId = '$discussionId'; ";
    $result = mysqli_query($connection, $ds);
    
   echo "<div class = \"dis\">";
    if ($row = mysqli_fetch_assoc($result)) {

        
        echo"<h1>".$row["title"]."</h1>";
       
        echo"<h3>By: ".$row["fullname"]."</h3>";
        echo "<br><br>";
        if($row["image"] !== null && $row["contentType"] !== null){
         
            echo '<img width = 350 height = 350  src="data:image/'.$row["contentType"].';base64,'.base64_encode($row["image"]).'"/> <br><br>';
        }
        echo "<h4>".$row["description"]."</h4>";
    echo "</div>";

      

?>
<div class = "comm">
        <h1>Comments: </h1>
        <form method = "POST" action = "../create/create_comment.php">   
        <textarea name = "comment" placeholder = "What are your thoughts?" required></textarea>
        <input name = "discussionId" type = "hidden" value = "<?php echo $discussionId ?>">
        <br>
        <button>Add Comment</button>
        </form>
        <br><br>

        

    <div id = "commentList">

</div>
    </div>


        <script>


        </script>
        
        


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
<script>

    var onEdit = false;

    function initialUpdateComments()
    {
        $.get("show_comments.php", {discussionId: <?php echo $discussionId ?>}, function(data){
            $("#commentList").html(data);
            addEventListeners(); // This will execute once function(data) is called, which means it's executed after the data has been successfully returned from show_comments.php
        })
    }

    function updateCommentsIfNotOnEdit() // During the interval loop, only update comment if onEdit == False
    {
        if(!onEdit)
        {
            $.get("show_comments.php", {discussionId: <?php echo $discussionId ?>}, function(data){
                $("#commentList").html(data);
                addEventListeners();
            })
        }

    }

    function addEventListeners()
    {
        $(".editButton").on("click", function(){

            onEdit = true;

        });


    }

    initialUpdateComments(); // Make our inital call to update comments, but this initial call will create our event listeners to change the value of "onEdit"
    setInterval(updateCommentsIfNotOnEdit, 5000);





</script>