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
        <div class="logo"> <a href = "show_discussions.php"> <img src="../../Images/logo.png" width="100" height="100"></a> </div>
        <div class="n"><div class="text">  <a href = "show_discussions.php"><p> The Tech Ward</p> </a></div>
        <?php $_SESSION['prev_page'] = $_SERVER['REQUEST_URI']; ?>
            <ul><li><a href="../login/logincheck.php">New Discussion</a></li>
                <li><a href="#">Search For Discussion</a></li>
                <li><a href="account.php">Account</a></li>
                <li><a href="../login/logout.php">Logout</a></li> </ul></div></nav>

</header> 
<br> <br>  <br> <br>  <br> <br>



<?php

// $host = "localhost";
// $database = "project";
// $user = "webuser";
// $password = "P@ssw0rd";

$host = "cosc360.ok.ubc.ca";
$database = "db_11505328";
$user = "11505328";
$password = "11505328";
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
        <textarea name = "comment" placeholder = "What are your thoughts?"></textarea>
        <input name = "discussionId" type = "hidden" value = "<?php echo $discussionId ?>">
        <br>
        <button>Add Comment</button>
        </form>
        <br><br>

        
        
    <?php
        $commentQuery = "SELECT commentId, comment.email as commentEmail, fullname, body, discussionId FROM user, comment WHERE user.email = comment.email AND comment.discussionId = '$discussionId'";
        $result = mysqli_query($connection, $commentQuery);

        while($row = $result->fetch_assoc())
        {
            echo "<div class = \"parent\" commentId = {$row['commentId']} discussionId = {$row['discussionId']}>";
            echo"<p>By: {$row['fullname']} </p>";
            echo "<div class = \"child\">";
            echo"<p>{$row['body']}</p>";
            session_start();
            if(!empty($_SESSION['email']) && strcmp($row['commentEmail'], $_SESSION['email']) === 0 )
            {
                echo "<button class = \"editButton\">Edit</button>";
                echo "<a href = \"../create/delete_comment.php?commentId={$row['commentId']}\"><button class = \"deleteButton\">Delete</button></a>";
            }
            echo "<br>";
            echo "</div>";
            echo "</div>";
        }

        // Support for comment

       
    ?>

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
            form = document.createElement("form");
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

        var deleteButtons = document.getElementByClassName("deleteButton");
        for(let i=0; i<deleteButtons.length; i++)
        {
            
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