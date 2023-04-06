
<style>
    .discussion{
        margin-top: 50px;
        display: flex;
        width: 100%;
        justify-content: flex-start;
        margin-left: 100px;
    }

    .edit-delete-buttons{
       position: absolute;
        margin-top: 50px;
    }

    .like-dislike-buttons{
        position: relative;
        right: 20px;
    }

    button:hover{
        cursor: pointer;
    }
</style>
<?php


use db\dbConnection;

session_start();
if (empty($_SESSION['visited'])) {
    $_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];
    header("Location: ../login/logincheck.php");
} else {
    unset($_SESSION['visited']);
}





require_once '../db/dbConnection.php';
$dbConnection = new dbConnection();
$connection = $dbConnection->getConnection();
$error = $dbConnection->getError();

$search = $_GET["search"];


$sql = "SELECT discussionId, title, fullname, user.email FROM discussion, user WHERE discussion.email = user.email AND title LIKE '$search%'";

$result = mysqli_query($connection, $sql);
while ($row = $result->fetch_assoc()) {

    /**  Get likes of given discussion Id*/
    $discussionId = $row["discussionId"];
    $getLikeCount = "SELECT COUNT(*) as likeCount FROM discussionRating WHERE discussionId = '$discussionId' AND isLike = 1";
    $likeCountResult = mysqli_query($connection, $getLikeCount);
    $likeCountResultRow = $likeCountResult->fetch_assoc();
    $likeCount = $likeCountResultRow["likeCount"];

    $getDislikeCount = "SELECT COUNT(*) as dislikeCount FROM discussionRating WHERE discussionId = '$discussionId' AND isLike = 0";
    $dislikeCountResult = mysqli_query($connection, $getDislikeCount);
    $dislikeCountResultRow = $dislikeCountResult->fetch_assoc();
    $dislikeCount = $dislikeCountResultRow["dislikeCount"];

    $totalRating = $likeCount - $dislikeCount;


    /**  Find if user liked or disliked particular discussion  */
    $email = $_SESSION["email"];
    $findIfCommentLikedOrDislikedByUser = "SELECT isLike FROM discussionRating WHERE discussionId = '$discussionId' AND email = '$email'";
    $isLikeResult = mysqli_query($connection, $findIfCommentLikedOrDislikedByUser);
    $isLikeResultRow = $isLikeResult->fetch_assoc();
    $isLike = $isLikeResultRow["isLike"];
    if($isLike == null)
        $isLike = -1;
    ?>
<div class = "discussion" discussionId = <?php echo $discussionId ?> >
    <div class = "like-dislike-buttons">
    <button class = "likeButton" <?php if($isLike == 1) echo "disabled"; ?> > &#8593</button>
    <br>
        <p class = "totalRating"><?php echo $totalRating; ?></p>
    <button class = "dislikeButton"  <?php if($isLike == 0) echo "disabled"; ?> >&#x2193</button>
    </div>
<?php
    echo "<a href = discussion.php?discussionId=".$discussionId."> <h3> Title: ".$row["title"]." </h3> <br> By:".$row["fullname"]."</a>";
    session_start();
    if($_SESSION["admin"] || $row["email"] == $_SESSION['email']) {
        ?>
    <div class = "edit-delete-buttons">
        <?php
        echo "<br>";
        echo "<a href='../create/delete_discussion.php?discussionId=" . $discussionId . "'><button>Delete</button></a>";
        echo "<a href='edit_my_discussion.php?discussionId=" . $discussionId . "'><button>Edit</button></a>";
        ?>
    </div>
        <?php
    }
    ?>
</div>
    <?php
}

?>


<script>

    $(".likeButton").on("click", function(){


        const discussionId =  $(this).parent().attr("discussionId");
      const currentLikeCount =parseInt($(this).siblings(".totalRating").text());

       /*
       $.get("../create/update_discussion_rating.php", {discussionId: discussionId, isLike: 1}, function(){
           $(this).siblings.(".likeCount").val(currentLikeCount+1);
       });
       */

        $(this).siblings(".totalRating").text(currentLikeCount+1);
        $(this).prop("disabled", true);
        $(this).siblings(".dislikeButton").prop("disabled", false);

    });


    $(".dislikeButton").on("click", function(){

        const discussionId =  $(this).parent().attr("discussionId");
        const currentLikeCount =parseInt($(this).siblings(".totalRating").text());

        /*
        $.get("../create/update_discussion_rating.php", {discussionId: discussionId, isLike: 1}, function(){
            $(this).siblings.(".likeCount").val(currentLikeCount+1);
        });
        */

        $(this).siblings(".totalRating").text(currentLikeCount-1);
        $(this).prop("disabled", true);
        $(this).siblings(".likeButton").prop("disabled", false);


    });

</script>


