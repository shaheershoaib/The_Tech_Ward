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
if($error != null){
  $output = "<p>Unable to connect to database!</p>";
  exit($output);
}
else{

    parse_str($_SERVER['QUERY_STRING'], $params);
    $discussionId = $params['discussionId'];


    $ds = "SELECT title, fullname, description FROM discussion, user WHERE discussion.email = user.email AND discussionId = '$discussionId'; ";
    $result = mysqli_query($connection, $ds);
    
   echo "<div class = \"dis\">";
    if ($row = mysqli_fetch_assoc($result)) {

        
        echo"<h1>".$row["title"]."</h1>";
        echo"<h3>By: ".$row["fullname"]."</h3>";
        echo "<br><br>";
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
           var editButtons = document.getElementsByClassName("editButton");
            for(let i=0; i<editButtons.length; i++) {
             editButtons[i].addEventListener("click", function() {
            var parentDiv = this.parentNode.parentNode;

            var childDiv = this.parentNode;

            var childDivComment = childDiv.firstChild.textContent;

            childDiv.remove();

            var editCommentTextArea = document.createElement("textarea");
            editCommentTextArea.innerHTML = childDivComment;
            editCommentTextArea.setAttribute("required", '');

            var form = document.createElement("form");
            form.setAttribute("method", "GET");
            form.setAttribute("action", "../create/edit_comment.php");

            var saveEditButton = document.createElement("button");
            saveEditButton.innerHTML = "Save Edit";
            editCommentTextArea.setAttribute("name", "comment");

            var hiddenCommentInput = document.createElement("input");
            hiddenCommentInput.setAttribute("type", "hidden");
            hiddenCommentInput.setAttribute("name", "commentId");
            hiddenCommentInput.setAttribute("value", parentDiv.getAttribute("commentId"));

            var hiddenDiscussionInput = document.createElement("input");
            hiddenDiscussionInput.setAttribute("type", "hidden");
            hiddenDiscussionInput.setAttribute("name", "discussionId");
            hiddenDiscussionInput.setAttribute("value", parentDiv.getAttribute("discussionId"));
          
            form.appendChild(editCommentTextArea);
            form.appendChild(saveEditButton);
            form.appendChild(hiddenCommentInput);
            form.appendChild(hiddenDiscussionInput);
            parentDiv.appendChild(form);
            
            });
        }

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

    function updateComments()
    {

        $.get("show_comments.php", {discussionId: <?php echo $discussionId ?>}, function(data){
            $("#commentList").html(data);
        })
        console.log("Updated comments");
    }


    updateComments();
    setInterval(updateComments, 5000);


</script>