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
    $(".editButton").on("click", function(){
        const parentDiv = $(this).parent().parent();
        const childDiv = $(this).parent();
        const childDivComment = childDiv.children().first().text();

        childDiv.remove();

        const editCommentTextArea = $('<textarea>').html(childDivComment).attr('required', '');
        const form = $('<form>').attr('method', 'GET').attr('action', '../create/edit_comment.php');
        const saveEditButton = $('<button>').html('Save Edit').addClass('saveEditButton');
        editCommentTextArea.attr('name', 'comment');
        const hiddenCommentInput = $('<input>').attr('type', 'hidden').attr('name', 'commentId').val(parentDiv.attr('commentId'));
        const hiddenDiscussionInput = $('<input>').attr('type', 'hidden').attr('name', 'discussionId').val(parentDiv.attr('discussionId'));

        form.append(editCommentTextArea);
        form.append(saveEditButton);
        form.append(hiddenCommentInput);
        form.append(hiddenDiscussionInput);
        parentDiv.append(form);
    });


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
