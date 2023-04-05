<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php


use db\dbConnection;

require_once '../db/dbConnection.php';
$dbConnection = new dbConnection();
$connection = $dbConnection->getConnection();
$error = $dbConnection->getError();
if($error!=null)
{
    exit($error);
}
$discussionId = $_GET["discussionId"];
$commentQuery = "SELECT commentId, comment.email as commentEmail, fullname, body, discussionId FROM user, comment WHERE user.email = comment.email AND comment.discussionId = '$discussionId'";
$result = mysqli_query($connection, $commentQuery);
$edit = false;

while ($row = $result->fetch_assoc()) {
    echo "<div class = \"parent\" commentId = {$row['commentId']} discussionId = {$row['discussionId']}>";
    echo "<p>By: {$row['fullname']} </p>";
    echo "<div class = \"child\">";
    echo "<p>{$row['body']}</p>";
    session_start();
    if ((!empty($_SESSION['email']) && strcmp($row['commentEmail'], $_SESSION['email']) === 0) || !empty($_SESSION['admin'])) {
        echo "<button class = \"editButton\">Edit</button>";
        echo "<a href = \"../create/delete_comment.php?commentId={$row['commentId']}\"><button class = \"deleteButton\">Delete</button></a>";
    }
    echo "<br>";
    echo "</div>";
    echo "</div>";
}



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
            editCommentTextArea.setAttribute("required", '');

            var form = document.createElement("form");
            form.setAttribute("method", "GET");
            form.setAttribute("action", "../create/edit_comment.php");

            var saveEditButton = document.createElement("button");
            saveEditButton.innerHTML = "Save Edit";
            saveEditButton.setAttribute("class", "saveEditButton");

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

<!--
<div class = parent commentId = commentId discussionId = discussionId>
    <p>By: fullname</p>
    <div class = child>
        <p>body</p>
        <button>edit</button>
        <button>delete</button>
        </div>
</div>
-->
