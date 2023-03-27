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
        echo "<h4>".$row["description"]."</h4>";

?>
        <h1>Comments</h1>
        <form method = "POST" action = "../create/create_comment.php">   
        <textarea name = "comment" placeholder = "What are your thoughts?"></textarea>
        <input name = "discussionId" type = "hidden" value = "<?php echo $discussionId ?>">
        <br>
        <button>Add Comment</button>
        </form>
        
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
                echo "<button class = \"deleteButton\"></button>";
            }
            echo "<br>";
            echo "</div>";
            echo "</div>";
        }

        // Support for comment

       
    ?>



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