<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style>

    .like-dislike-buttons {
        position: absolute;
    }

    .by, .child, textarea {
margin-left: 50px;
    }



    button:hover{
        cursor: pointer;
    }

    .parent {
        position: relative;
        margin-top: 20px;
    }




    }
</style>
<?php
session_start();

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
    $commentId = $row["commentId"];
    $getLikeCount = "SELECT SUM(isLike) as likeCount FROM commentRating WHERE commentId = '$commentId'";
    $likeCountResult = mysqli_query($connection, $getLikeCount);
    $likeCountResultRow = $likeCountResult->fetch_assoc();
    $totalRating = $likeCountResultRow["likeCount"];
    if($totalRating == null)
        $totalRating = 0;


    /**  Find if user liked or disliked particular discussion  */
    $email = $_SESSION["email"];
    $findIfCommentLikedOrDislikedByUser = "SELECT isLike FROM commentRating WHERE commentId = '$commentId' AND email = '$email'";
    $isLikeResult = mysqli_query($connection, $findIfCommentLikedOrDislikedByUser);
    $isLikeResultRow = $isLikeResult->fetch_assoc();
    $isLike = $isLikeResultRow["isLike"];
    if($isLike == null)
        $isLike = 0;


    echo "<div class = \"parent\" commentId = {$row['commentId']} discussionId = {$row['discussionId']}>";
    ?>
    <?php session_start(); ?>


        <?php if( !empty($_SESSION["email"]) ){ ?>

    <div class = "like-dislike-buttons" hasRated = <?php if($isLike != 0 ) echo "1"; else echo "0"; ?> >
        <button class = "likeButton" <?php if($isLike == 1) echo "disabled"; ?> > &#8593</button>
        <br>
        <p class = "totalRating"> <?php echo $totalRating; ?></p>
        <button class = "dislikeButton"  <?php if($isLike == -1) echo "disabled"; ?> >&#x2193</button>
    </div>

            <?php } ?>

<?php
    echo "<p class = \"by\" >By: {$row['fullname']} </p>";
    echo "<div class = \"child\">";
    echo "<p>{$row['body']}</p>";


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
    <?php session_start(); ?>


    $(".editButton").on("click", function(){
        const parentDiv = $(this).parent().parent();
        const childDiv = $(this).parent();
        const childDivComment = childDiv.children().first().text();

        childDiv.remove();

        const editCommentTextArea = $('<textarea>').html(childDivComment).attr('required', '');
        const form = $('<form>').attr('method', 'POST').attr('action', '../create/edit_comment.php');
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



    $(".likeButton").on("click", function(){


        const commentId =  $(this).parent().parent().attr("commentId");
        const currentLikeCount =parseInt($(this).siblings(".totalRating").text());

        const hasRated = $(this).parent().attr("hasRated");

        var newLikeCount = 0;
        if(hasRated == "1")
            newLikeCount = currentLikeCount+2;
        else newLikeCount = currentLikeCount+1;

        $(this).siblings(".totalRating").text(newLikeCount);
        $(this).prop("disabled", true);
        $(this).parent().attr("hasRated", "1");
        $(this).siblings(".dislikeButton").prop("disabled", false);

        $.post("../create/update_comment_rating.php", {commentId: commentId, isLike: 1}, function(){

        });




    });


    $(".dislikeButton").on("click", function(){


        const commentId =  $(this).parent().parent().attr("commentId");
        const currentLikeCount =parseInt($(this).siblings(".totalRating").text());
        const hasRated = $(this).parent().attr("hasRated");
        var newLikeCount = 0;
        if(hasRated == "1")
            newLikeCount = currentLikeCount-2;
        else newLikeCount = currentLikeCount-1;

        $(this).siblings(".totalRating").text(newLikeCount);
        $(this).prop("disabled", true);
        $(this).parent().attr("hasRated", "1");
        $(this).siblings(".likeButton").prop("disabled", false);

        $.post("../create/update_comment_rating.php", {commentId: commentId, isLike: -1}, function(){

        });




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
